/**
 * Specific JS for the classic theme
 * 
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Initializes the slider for the thumbnail gallery (small images)
 */
AimeosCatalogDetail.setupThumbnailSlider = function() {

	/* Slider for thumbnail gallery (small ones) */
	$(".catalog-detail-image .thumbs").carouFredSel({
		responsive: false,
		circular: false,
		infinite: false,
		auto: false,
		prev: ".prev-thumbs",
		next: ".next-thumbs",
		items: {
			visible: {
				min: 2,
				max: 3
			}
		},
		swipe: true,
		mousewheel: true
	});
};

AimeosCatalogDetail.setupAdditionalContentSlider = function() {};
AimeosCatalogDetail.setupBlockPriceSlider = function() {};
AimeosCatalogFilter.setupCategoryToggle = function() {};
AimeosCatalogFilter.setupAttributeToggle = function() {};
AimeosCatalogFilter.setupAttributeListsToggle = function() {};
