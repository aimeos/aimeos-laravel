(function( $ ) {

	$.widget( "ai.combobox", {

		_create: function() {

			this.wrapper = $( "<span>" ).addClass( "ai-combobox" ).insertAfter( this.element );

			this.element.hide();
			this._createAutocomplete();
			this._createShowAll();
		},


		_createAutocomplete: function() {

			var selected = this.element.children( ":selected" );
			var value = selected.val() ? selected.text() : "";
			var self = this;

			this.input = $( "<input>" );
			this.input.appendTo( this.wrapper );
			this.input.val( value );
			this.input.attr( "title", "" );
			this.input.addClass( "ai-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" );

			this.input.autocomplete({
				delay: 0,
				minLength: 0,
				source: $.proxy( this, "_source" ),
				select: function(ev, ui) {
					self.element.val(ui.item.value).find("input").val(ui.item.label);
					ev.preventDefault();
				},
				focus: function(ev, ui) {
					self.element.val(ui.item.value).next().find("input").val(ui.item.label);
					ev.preventDefault();
				}
			});

			this.input.tooltip({
				tooltipClass: "ui-state-highlight"
			});

			this._on( this.input, {
				autocompleteselect: function( event, ui ) {
					ui.item.option.selected = true;
					this._trigger( "select", event, {
						item: ui.item.option
					});
				},

				autocompletechange: "_removeInvalid"
			});
		},


		_createShowAll: function() {

			var input = this.input;
			var wasOpen = false;

			var btn = $( '<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icons-only"><span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-s"></span></button>' );

			btn.attr( "tabIndex", -1 );
			btn.appendTo( this.wrapper );
			btn.button();
			btn.removeClass( "ui-corner-all" );
			btn.addClass( "ai-combobox-toggle ui-corner-right" );

			btn.mousedown(function() {
				wasOpen = input.autocomplete( "widget" ).is( ":visible" );
			});

			btn.click(function(ev) {
				ev.preventDefault();
				input.focus();

				// Close if already visible
				if ( wasOpen ) {
					return;
				}

				// Pass empty string as value to search for, displaying all results
				input.autocomplete( "search", "" );
			});
		},


		_source: function( request, response ) {
			this.options.getfcn( request, response, this.element );
		},


		_removeInvalid: function( event, ui ) {

			// Selected an item, nothing to do
			if ( ui.item ) {
				return;
			}

			// Search for a match (case-insensitive)
			var valueLowerCase = this.input.val().toLowerCase();
			var valid = false;

			this.element.children( "option" ).each(function() {
				if ( $( this ).text().toLowerCase() === valueLowerCase ) {
					this.selected = valid = true;
					return false;
				}
			});

			// Found a match, nothing to do
			if ( valid ) {
				return;
			}

			// Remove invalid value
			this.input.val( "" );
			this.element.val( "" );
			this.input.autocomplete( "instance" ).term = "";
		},


		_destroy: function() {

			this.wrapper.remove();
			this.element.show();
		}
	});

})( jQuery );



Aimeos = {

	options : null,


	init : function() {

		this.checkFields();
		this.checkSubmit();
		this.createDatePicker();
		this.showErrors();
	},


	addClone : function(node, getfcn, selectfn) {

		var clone = node.clone().removeClass("prototype");
		var combo = $(".combobox-prototype", clone);

		combo.combobox({getfcn: getfcn, select: selectfn});
		combo.removeClass("combobox-prototype");
		combo.addClass("combobox");

		$("[disabled='disabled']", clone).prop("disabled", false);
		clone.insertBefore(node);

		return clone;
	},


	checkFields : function() {

		$(".aimeos .item .mandatory").on("blur", "input,select", function(ev) {

			if($(this).val() !== '') {
				$(ev.delegateTarget).removeClass("has-danger").addClass("has-success");
			} else {
				$(ev.delegateTarget).removeClass("has-success").addClass("has-danger");
			}
		});


		$(".aimeos .item .form-group").on("blur", "input[data-pattern]", function(ev) {

			var elem = $(this);

			if(elem.val().match(elem.data("pattern"))) {
				$(ev.delegateTarget).removeClass("has-danger").addClass("has-success");
			} else {
				$(ev.delegateTarget).removeClass("has-success").addClass("has-danger");
			}
		});
	},


	checkSubmit : function() {

		$(".aimeos form").on("submit", function(ev) {
			var retval = true;
			var nodes = [];

			$(".card-header", this).removeClass("has-danger");

			$(".card:visible .mandatory", this).each(function(idx, element) {
				var elem = $(element);
				var value = elem.find("input,select").val();

				if(value === null || value.trim() === "") {
					elem.parents(".form-group").addClass("has-danger");
					nodes.push(element);
					retval = false;
				} else {
					elem.parents(".form-group").removeClass("has-danger");
				}
			});

			$(".card:visible input[data-pattern]", this).each(function(idx, element) {
				var elem = $(element);
				var value = elem.val();
				var regex = new RegExp(elem.data('pattern'));

				if(value !== null && value.match(regex) === null) {
					elem.parents(".form-group").addClass("has-danger");
					nodes.push(element);
					retval = false;
				} else {
					elem.parents(".form-group").removeClass("has-danger");
				}
			});

			$.each(nodes, function(idx, node) {
				$(node).parents(".card").find(".card-header").addClass("has-danger");
			});

			if( nodes.length !== 0 ) {
				$('html, body').animate({
					scrollTop: $(nodes).first().offset().top + 'px'
				});
			}

			return retval;
		});
	},


	createDatePicker : function() {

		$(".aimeos .date").each(function(idx, elem) {

			$(elem).datepicker({
				dateFormat: $(elem).data("format"),
				constrainInput: false
			});
		});
	},


	getOptions : function(request, response, element, domain, key, sort) {

		Aimeos.options.done(function(data) {

			var compare = {}, field = {}, params = {}, param = {};
			var prefix = $("body").data("prefix");

			compare[key] = request.term;
			field[domain] = key;

			param['filter'] = {'&&': [{'=~': compare}]};
			param['fields'] = field;
			param['sort'] = sort;

			if( prefix ) {
				params[prefix] = param;
			} else {
				$params = param;
			}

			$.ajax({
				dataType: "json",
				url: data.meta.resources[domain] || null,
				data: params,
				success: function(result) {
					var list = result.data || [];

					$("option", element).remove();

					response( list.map(function(obj) {

						var opt = $("<option/>");

						opt.attr("value", obj.id);
						opt.text(obj.attributes[key]);
						opt.appendTo(element);

						return {
							label: obj.attributes[key] || null,
							value: obj.id,
							option: opt
						};
					}));
				}
			});
		});
	},


	getOptionsAttributes : function(request, response, element) {
		Aimeos.getOptions(request, response, element, 'attribute', 'attribute.label', 'attribute.label');
	},


	getOptionsCategories : function(request, response, element) {
		Aimeos.getOptions(request, response, element, 'catalog', 'catalog.label', 'catalog.label');
	},


	getOptionsCurrencies : function(request, response, element) {
		Aimeos.getOptions(request, response, element, 'locale/currency', 'locale.currency.id', '-locale.currency.status,locale.currency.id');
	},


	getOptionsLanguages : function(request, response, element) {
		Aimeos.getOptions(request, response, element, 'locale/language', 'locale.language.id', '-locale.language.status,locale.language.id');
	},


	getOptionsSites : function(request, response, element) {
		Aimeos.getOptions(request, response, element, 'locale/site', 'locale.site.label', '-locale.site.status,locale.site.label');
	},


	getOptionsProducts : function(request, response, element) {
		Aimeos.getOptions(request, response, element, 'product', 'product.label', 'product.label');
	},


	showErrors : function() {

		$(".aimeos .error-list .error-item").each(function() {
			$(".aimeos ." + $(this).data("key") + " .header").addClass("has-danger");
		});
	}
};



Aimeos.Product = {

	init : function() {

		Aimeos.Product.Filter.init();
		Aimeos.Product.List.init();
		Aimeos.Product.Item.init();
	}
};



Aimeos.Product.Filter = {

	filterattr : null,


	init : function() {

		this.addFilterKeys();
		this.addFilterItem();
		this.removeFilterItem();
		this.toggleSearchItems();
	},


	addKeys : function(e) {

		var self = $(this);
		var opitem = self.parents(".filter-item").find(".filter-operator");

		if( $("option", self).length !== 0 ) {
			return;
		}

		Aimeos.Product.Filter.filterattr.done(function(data) {

			var code = self.data("selected");
			var keys = data.meta && data.meta.attributes || {};

			$.each(keys, function(key, attr) {
				if( attr['public'] && attr['code'] === code ) {
					self.append('<option value=' + attr['code'] + ' selected="selected">' + attr['label'] + '</option>');
				} else if( attr['public'] ) {
					self.append('<option value=' + attr['code'] + '>' + attr['label'] + '</option>');
				}
			});

			if( code && data.meta && data.meta.attributes && data.meta.attributes[code] ) {
				$("option." + data.meta.attributes[code].type, opitem).show();
			}

			self.selectmenu("refresh");
		});
	},


	selectKeys : function(e, ui) {

		var opitem = $(this).parents(".filter-item").find(".filter-operator");
		$("option", opitem).hide().removeProp("selected");

		Aimeos.Product.Filter.filterattr.done(function(data) {

			if( data.meta && data.meta.attributes && data.meta.attributes[ui.item.value] && data.meta.attributes[ui.item.value].type ) {
				var options = $("option." + data.meta.attributes[ui.item.value].type, opitem);
				options.first().prop("selected", "selected");
				options.show();
			}
		});
	},


	addFilterKeys : function() {

		var self = this;

		Aimeos.options.done(function(data) {

			var url = data.meta && data.meta.resources && data.meta.resources['product'] || null;

			self.filterattr = $.ajax(url, {
				"method": "OPTIONS",
				"dataType": "json"
			});

			$( ".aimeos .filter-item .filter-key" ).selectmenu({
				select: self.selectKeys,
				create: self.addKeys
			});
		});
	},


	addFilterItem : function() {

		var self = this;

		$(".aimeos .filter-items").on("click", ".fa-plus", function(e) {
			var proto = $(".prototype", e.delegateTarget);
			var clone = proto.clone().insertBefore(proto);

			$("input,select", clone).prop("disabled", false);
			clone.removeClass("prototype").addClass("filter-item");
			$(this).removeClass("fa-plus").addClass("fa-minus");

			$(".filter-key", clone).selectmenu({
				select: self.selectKeys,
				create: self.addKeys
			});
		});
	},


	removeFilterItem : function() {

		$(".aimeos .list-filter .filter-items").on("click", ".fa-minus", function(e) {
			var item = $(this).parents(".filter-item");

			item.find(".filter-key").selectmenu("destroy");
			item.remove();
		});
	},


	toggleSearchItems : function() {

		$(".aimeos .list-filter, .aimeos .list-fields").on("click", ".action", function(e) {

			$(".filter-items, .fields-items", e.delegateTarget).toggle();
			$(this).toggleClass("action-close");

			if( $(".aimeos .list-search .search-item:visible").length > 0 ) {
				$(".aimeos .list-search .actions-group").show();
			} else {
				$(".aimeos .list-search .actions-group").hide();
			}
		});
	}
};



Aimeos.Product.List = {

	element : null,


	init : function() {

		this.askDelete();
		this.confirmDelete();
	},


	askDelete : function() {
		var self = this;

		$(".list-items").on("click", ".fa-trash", function(e) {
			$("#confirm-delete").modal("show", $(this));
			self.element = $(this).parents("form.delete");
			return false;
		});
	},


	confirmDelete : function() {
		var self = this;

		$("#confirm-delete").on("click", ".btn-danger", function(e) {
			$(self.element).submit();
		});
	}
};



Aimeos.Product.Item = {

	init : function() {

		this.addConfigLine();
		this.deleteConfigLine();
		this.configComplete();

		Aimeos.Product.Item.Bundle.init();
		Aimeos.Product.Item.Category.init();
		Aimeos.Product.Item.Image.init();
		Aimeos.Product.Item.Price.init();
		Aimeos.Product.Item.Selection.init();
		Aimeos.Product.Item.Stock.init();
		Aimeos.Product.Item.Text.init();
		Aimeos.Product.Item.Download.init();
	},


	addConfigLine : function() {

		$(".aimeos .item-config").on("click", ".fa-plus", function(ev) {

			var clone = Aimeos.addClone($(".prototype", ev.delegateTarget));

			$(".config-key", clone).autocomplete({
				source: ['css-class'],
				minLength: 0,
				delay: 0
			});
		});
	},


	deleteConfigLine : function() {

		$(".aimeos .item-config .fa-trash").on("click", function(ev) {
			$(this).parents("tr").remove();
		});

		$(".aimeos .item-config").on("click", ".fa-trash", function(ev) {
			$(this).parents("tr").remove();
		});
	},


	configComplete : function() {

		$(".aimeos .config-item .config-key").autocomplete({
			source: ['css-class'],
			minLength: 0,
			delay: 0
		});

		$(".aimeos .item").on("click", " .config-key", function(ev) {
			$(this).autocomplete("search", "");
		});
	}
};



Aimeos.Product.Item.Bundle = {

	init : function() {

		this.addLine();
		this.removeLine();
		this.setupComponents();
		this.showBundles();
	},


	addLine : function() {

		$(".product-item-bundle").on("click", ".fa-plus", function(ev) {
			Aimeos.addClone(
				$(".prototype", ev.delegateTarget),
				Aimeos.getOptionsProducts,
				Aimeos.Product.Item.Bundle.select);
		});
	},


	removeLine : function() {

		$(".product-item-bundle").on("click", ".fa-trash", function() {
			$(this).parents("tr").remove();
		});
	},


	select: function(ev, ui) {

		var node = $(ev.delegateTarget);
		node.parents("tr").find("input.item-label").val(node.val());
	},


	setupComponents : function() {

		$(".product-item-bundle .combobox").combobox({
			getfcn: Aimeos.getOptionsProducts,
			select: Aimeos.Product.Item.Bundle.select
		});
	},


	showBundles : function() {

		var panel = $(".product-item-bundle");
		$(".product-item .item-typeid option[selected]").data("code") === 'bundle' ? panel.show() : panel.hide();

		$(".product-item .item-typeid").on("change", function() {
			$("option:selected", this).data("code") === 'bundle' ? panel.show() : panel.hide();
		});
	}
};



Aimeos.Product.Item.Category = {

	init : function() {

		this.addLine();
		this.removeLine();
		this.setupComponents();
	},


	addLine : function() {

		$(".product-item-category").on("click", ".fa-plus", function(ev) {
			Aimeos.addClone(
				$(".prototype", ev.delegateTarget),
				Aimeos.getOptionsCategories,
				Aimeos.Product.Item.Category.select);
		});
	},


	removeLine : function() {

		$(".product-item-category").on("click", ".fa-trash", function() {
			$(this).parents("tr").remove();
		});
	},


	select: function(ev, ui) {

		var node = $(ev.delegateTarget);
		node.parents("tr").find("input.item-label").val(node.val());
	},


	setupComponents : function() {

		$(".product-item-category .combobox").combobox({
			getfcn: Aimeos.getOptionsCategories,
			select: Aimeos.Product.Item.Category.select
		});
	}
};



Aimeos.Product.Item.Image = {

	init : function() {

		this.addLines();
		this.removeLine();
		this.setupComponents();
	},


	addLines : function() {

		$(".product-item-image").on("change", ".fileupload", function(ev) {

			$(this).each( function(idx, el) {
				$(".upload", ev.delegateTarget).remove();
				var line = $(".prototype", ev.delegateTarget);

				for(i=0; i<el.files.length; i++) {

					var img = new Image();
					var file = el.files[i];
					var clone = Aimeos.addClone(line, Aimeos.getOptionsLanguages);

					clone.addClass("upload");
					$("input.item-label", clone).val(el.files[i].name);

					img.src = file;
					$(".image-preview", clone).append(img);

					var reader = new FileReader();
					reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
					reader.readAsDataURL(file);
				}
			});
		});
	},


	removeLine : function() {

		$(".product-item-image").on("click", ".fa-trash", function() {
			$(this).parents("tr").remove();
		});
	},


	setupComponents : function() {

		$(".product-item-image .image-language .combobox").combobox({getfcn: Aimeos.getOptionsLanguages});
	}
};



Aimeos.Product.Item.Price = {

	init : function() {

		this.copyBlock();
		this.removeBlock();
		this.setupComponents();
		this.updateHeader();
	},


	copyBlock : function() {

		$(".product-item-price").on("click", ".header .fa-files-o", function(ev) {
			var block = $(this).parents(".group-item");
			var clone = block.clone();

			clone.insertAfter(block);
			$(".ai-combobox", clone).remove();
			$(".combobox", clone).combobox({getfcn: Aimeos.getOptionsCurrencies});
		});
	},


	removeBlock : function() {

		$(".product-item-price").on("click", ".header .fa-trash", function() {
			$(this).parents(".group-item").remove();
		});
	},


	setupComponents : function() {

		$(".product-item-price .combobox").combobox({getfcn: Aimeos.getOptionsCurrencies});
	},


	updateHeader : function() {

		$(".product-item-price").on("blur", "input.item-label", function() {
			var item = $(this).parents(".group-item");
			var value = $(this).val();

			$(".header .item-label", item).html(value);
		});
	}
};



Aimeos.Product.Item.Selection = {

	init : function() {

		this.copyBlock();
		this.removeBlock();
		this.addAttribute();
		this.removeAttribute();
		this.setupComponents();
		this.showSelection();
		this.updateCode();
	},


	addAttribute : function() {

		$(".product-item-selection").on("click", ".selection-item-attributes .fa-plus", function(ev) {

			var code = $(this).parents(".group-item").find("input.item-code").val();
			var line = $(this).parents(".selection-item-attributes").find(".prototype");
			var clone = Aimeos.addClone(line, Aimeos.getOptionsAttributes, Aimeos.Product.Item.Selection.select);

			$("input.item-attr-ref", clone).val(code);
		});
	},


	removeAttribute : function() {

		$(".product-item-selection").on("click", ".selection-item-attributes .fa-trash", function() {
			$(this).parents("tr").remove();
		});
	},


	copyBlock : function() {

		$(".product-item-selection").on("click", ".header .fa-files-o", function(ev) {
			var block = $(this).parents(".group-item");
			var clone = block.clone();

			clone.insertAfter(block);
			$(".ai-combobox", clone).remove();
			$(".combobox", clone).combobox({
				getfcn: Aimeos.getOptionsAttributes,
				select: Aimeos.Product.Item.Selection.select
			});

			var codeNode = $("input.item-code", clone);
			codeNode.val(codeNode.val() + '_copy');
			codeNode.trigger("blur");

			$("input.item-listid", clone).val('');
			$("input.item-id", clone).val('');
			$("p.item-id", clone).empty();
		});
	},


	removeBlock : function() {

		$(".product-item-selection").on("click", ".header .fa-trash", function() {
			$(this).parents(".group-item").remove();
		});
	},


	select: function(ev, ui) {

		var node = $(ev.delegateTarget);
		node.parents("tr").find("input.item-attr-label").val(node.val());
	},


	setupComponents : function() {

		$(".product-item-selection .combobox").combobox({
			getfcn: Aimeos.getOptionsAttributes,
			select: Aimeos.Product.Item.Selection.select
		});
	},


	showSelection : function() {

		var panel = $(".product-item-selection");
		$(".product-item .item-typeid option[selected]").data("code") === 'select' ? panel.show() : panel.hide();

		$(".product-item .item-typeid").on("change", function() {
			$("option:selected", this).data("code") === 'select' ? panel.show() : panel.hide();
		});
	},


	updateCode : function() {

		$(".product-item-selection").on("blur", "input.item-code", function() {
			var item = $(this).parents(".group-item");
			var value = $(this).val();

			$(".header .item-code", item).html(value);
			$(".selection-item-attributes .item-attr-ref", item).val(value);
		});
	}
};



Aimeos.Product.Item.Stock = {

	init : function() {

		this.addLine();
		this.removeLine();
	},


	addLine : function() {

		$(".product-item-stock").on("click", ".fa-plus", function(ev) {

			var clone = Aimeos.addClone($(".prototype", ev.delegateTarget));

			$(".date-prototype", clone).each(function(idx, elem) {
				$(elem).addClass("date").removeClass("date-prototype");
				$(elem).datepicker({
					dateFormat: $(elem).data("format"),
					constrainInput: false
				});
			});
		});
	},


	removeLine : function() {

		$(".product-item-stock").on("click", ".fa-trash", function() {
			$(this).parents("tr").remove();
		});
	}
};



Aimeos.Product.Item.Text = {

	editorcfg : [
		{ name: 'clipboard', items: [ 'Undo', 'Redo' ] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'insert', items: [ 'Image', 'SpecialChar' ] },
		{ name: 'tools', items: [ 'Maximize' ] },
		{ name: 'document', items: [ 'Source' ] },
		'/',
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat' ] },
		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] }
	],


	init : function() {

		this.copyBlock();
		this.removeBlock();
		this.setupComponents();
		this.updateHeader();
	},


	copyBlock : function() {

		$(".product-item-text").on("click", ".header .fa-files-o", function(ev) {
			var block = $(this).parents(".group-item");
			var clone = block.clone();

			clone.insertAfter(block);
			$(".cke", clone).remove();
			$(".ai-combobox", clone).remove();
			$(".combobox", clone).combobox({getfcn: Aimeos.getOptionsLanguages});
			$(".htmleditor", clone).ckeditor({toolbar: Aimeos.Product.Item.Text.editorcfg});
		});
	},


	removeBlock : function() {

		$(".product-item-text").on("click", ".header .fa-trash", function() {
			$(this).parents(".group-item").remove();
		});
	},


	setupComponents : function() {

		$(".product-item-text .combobox").combobox({getfcn: Aimeos.getOptionsLanguages});
		$(".product-item-text .htmleditor").ckeditor({toolbar: Aimeos.Product.Item.Text.editorcfg});
	},


	updateHeader : function() {

		$(".product-item-text").on("blur", "input.item-name-content", function() {
			var item = $(this).parents(".group-item");
			var value = $(this).val();

			$(".header .item-name-content", item).html(value);
		});
	}
};



Aimeos.Product.Item.Download = {

	init : function() {

		this.addLines();
		this.removeLine();
	},


	addLines : function() {

		$(".product-item-download").on("change", ".fileupload", function(ev) {

			$(this).each( function(idx, el) {
				$(".upload", ev.delegateTarget).remove();
				var line = $(".prototype", ev.delegateTarget);

				for(i=0; i<el.files.length; i++) {

					var file = el.files[i];
					var clone = Aimeos.addClone(line, Aimeos.getOptionsLanguages);

					clone.addClass("upload");
					$("input.item-label", clone).val(el.files[i].name);
				}
			});
		});
	},


	removeLine : function() {

		$(".product-item-download").on("click", ".fa-trash", function() {
			$(this).parents("tr").remove();
		});
	}
};



/**
 * Load JSON admin resource definition immediately
 */
Aimeos.options = $.ajax($(".aimeos").data("url"), {
	"method": "OPTIONS",
	"dataType": "json"
});


$(function() {

	Aimeos.init();
	Aimeos.Product.init();
});
