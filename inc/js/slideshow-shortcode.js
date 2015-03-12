function OpeningTimesSlideshow( element, width, height, transition ) {
	this.element = element; // the slideshow object
	this.images = []; // an empty arrary of images
	this.controls = {}; // the controls
	this.transition = transition || 'fade'; // the transition

	/* this may not be necessary with cycle2 */
	var currentWidth = this.element.width(); // measure the element
	if ( !width || width > currentWidth ) // if there is no width, or the width is greater than the current width
		width = currentWidth;

	this.width = width;
	this.height = height;
	this.element.css( {
		'height': this.height + 'px'
		} );
}

/* Set up the loader -- info taken from the wp_localize_script. Keep */
OpeningTimesSlideshow.prototype.showLoadingImage = function( toggle ) {
	if ( toggle ) {
		this.loadingImage_ = document.createElement( 'div' );
		this.loadingImage_.className = 'slideshow-loading';
		var img = document.createElement( 'img' );
		img.src = OpeningTimesSlideshowSettings.spinner;
		this.loadingImage_.appendChild( img );
		//this.loadingImage_.appendChild( this.makeZeroWidthSpan() );
		this.loadingImage_.style.lineHeight = this.height + 'px';
		this.element.append( this.loadingImage_ );
	} else if ( this.loadingImage_ ) {
		this.loadingImage_.parentNode.removeChild( this.loadingImage_ );
		this.loadingImage_ = null;
	}
};

OpeningTimesSlideshow.prototype.init = function() {
	this.showLoadingImage(true);

	var self = this;
	// Set up DOM.
	for ( var i = 0; i < this.images.length; i++ ) { //count the images from the array declared above
		var imageInfo = this.images[i]; // identify the each image
		var img = document.createElement( 'img' ); // create an img element in the dom
		img.src = imageInfo.src + '?w=' + this.width; // declare the src and width attribute -- src="image declared in imageInfo variable" width is the width of that image.
		img.align = 'middle'; // middle align the image
		var caption = document.createElement( 'div' ); // create a div for the caption. May not be necessary with cycle2 as caption can be declared in the data attribute. But an empty div may be needed for custom markup - <div class="cycle-overlay custom"></div>
		caption.className = 'slideshow-slide-caption gallery-caption'; // ... assign it a class
		caption.innerHTML = imageInfo.caption; // output the contents of the caption - the image identified in imageInfo and the markup declared in caption
		var container = document.createElement('div'); // create a div to wrap around the individual slide. May not be necessary with cycle2, see above.
		container.className = 'slideshow-slide'; // ... assign it a class. Probably not needed, see above.
		container.style.lineHeight = this.height + 'px'; // declare a height. Probably not needed, see above.

		// Hide loading image once first image has loaded.
		if ( i == 0 ) { // if there is an image
			if ( img.complete ) {
				// IE, image in cache
				setTimeout( function() {
					self.finishInit_();
				}, 1);
			} else {
				jQuery( img ).load(function() {
					self.finishInit_();
				});
			}
		}
		container.appendChild( img ); // append the image to the slide wrapper div
		// I'm not sure where these were coming from, but IE adds
		// bad values for width/height for portrait-mode images
		img.removeAttribute('width');
		img.removeAttribute('height');
		//container.appendChild( this.makeZeroWidthSpan() );
		container.appendChild( caption ); // append the caption to the slide wrapper div
		this.element.append( container ); // append the container to the slide show
	}
};

/*
OpeningTimesSlideshow.prototype.makeZeroWidthSpan = function() {
	var emptySpan = document.createElement( 'span' );
	emptySpan.className = 'slideshow-line-height-hack';
	// Having a NBSP makes IE act weird during transitions, but other
	// browsers ignore a text node with a space in it as whitespace.
	if (jQuery.browser.msie) {
		emptySpan.appendChild( document.createTextNode(' ') );
	} else {
		emptySpan.innerHTML = '&nbsp;';
	}
	return emptySpan;
};
*/

// Lets initialise the controls and define our variables
OpeningTimesSlideshow.prototype.finishInit_ = function() {
	this.showLoadingImage( false );
	this.renderControls_();

	var self = this;
	// Initialize Cycle instance.
	this.element.cycle( {
		fx: this.transition,
		prev: this.controls.prev,
		next: this.controls.next,
		timeout: 0,
		slideExpr: '.slideshow-slide',
		onPrevNextEvent: function() {
			return self.onCyclePrevNextClick_.apply( self, arguments );
		}
	} );

	/*
	var slideshow = this.element;
	jQuery( this.controls['stop'] ).click( function() {
		var button = jQuery(this);
		if ( ! button.hasClass( 'paused' ) ) {
			slideshow.cycle( 'pause' );
			button.removeClass( 'running' );
			button.addClass( 'paused' );
		} else {
			button.addClass( 'running' );
			button.removeClass( 'paused' );
			slideshow.cycle( 'resume', true );
		}
		return false;
	} );
	*/

	/*
	var controls = jQuery( this.controlsDiv_ );
	slideshow.mouseenter( function() {
		controls.fadeIn();
	} );
	slideshow.mouseleave( function() {
		controls.fadeOut();
	} );
	*/

	this.initialized_ = true;
};

// Create the navigation elements
OpeningTimesSlideshow.prototype.renderControls_ = function() {
	if ( this.controlsDiv_ )
		return;

	var controlsDiv = document.createElement( 'div' );
	controlsDiv.className = 'slideshow-controls';

	controls = [ 'prev', 'next' ];
	for ( var i = 0; i < controls.length; i++ ) {
		var controlName = controls[i];
		var a = document.createElement( 'a' );
		a.href = '#';
		controlsDiv.appendChild( a );
		this.controls[controlName] = a;
	}
	this.element.append( controlsDiv );
	this.controlsDiv_ = controlsDiv;
};

// Navigate from slide to slide
OpeningTimesSlideshow.prototype.onCyclePrevNextClick_ = function( isNext, i, slideElement ) {
	// If blog_id not present don't track page views
	if ( ! OpeningTimesSlideshowSettings.blog_id )
		return;

	var postid = this.images[i].id;
	var stats = new Image();
	stats.src = document.location.protocol +
		'//stats.wordpress.com/g.gif?host=' +
		escape( document.location.host ) +
		'&rand=' + Math.random() +
		'&blog=' + OpeningTimesSlideshowSettings.blog_id +
		'&subd=' + OpeningTimesSlideshowSettings.blog_subdomain +
		'&user_id=' + OpeningTimesSlideshowSettings.user_id +
		'&post=' + postid +
		'&ref=' + escape( document.location );
};

( function ( $ ) {
	function opening_times_slideshow_init() {
		$( '.opening_times-slideshow-noscript' ).remove();

		$( '.opening_times-slideshow' ).each( function () {
			var container = $( this );

			if ( container.data( 'processed' ) )
				return;

			var slideshow = new OpeningTimesSlideshow( container, container.data( 'width' ), container.data( 'height' ), container.data( 'trans' ) );
			slideshow.images = container.data( 'gallery' ); //THIS is where the images are pulled from
			slideshow.init();

			container.data( 'processed', true );
		} );
	}

	$( document ).ready( opening_times_slideshow_init );
	$( 'body' ).on( 'post-load', opening_times_slideshow_init );
} )( jQuery );