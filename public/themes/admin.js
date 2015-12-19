Aimeos = {};

Aimeos.Common = {

	init : function() {
		
		Aimeos.Common.askDelete();
		Aimeos.Common.confirmDelete();
	},

	
	askDelete : function() {
		
		$(".fa-trash").on("click", function(e) {
			$("#confirm-delete").modal('show', $(this));
			return false;
		});
	},
	
	
	confirmDelete : function() {
		
		$('#confirm-delete').on('show.bs.modal', function(e) {
			$('.btn-danger', this).attr('href', $(e.relatedTarget).attr('href'));
		});
	}
};



Aimeos.Filter = {

	promise : null,


	init : function() {

		this.promise = $.ajax($("body").data("url"), {
			"method": "OPTIONS",
			"dataType": "json"
		});
		
		Aimeos.Filter.addFilterKeys();
		Aimeos.Filter.addFilterItem();
		Aimeos.Filter.removeFilterItem();
		Aimeos.Filter.toggleSearchItems();
	},
		

	addKeys : function(e) {
		var that = $(this);
		var opitem = that.parents(".filter-item").find(".filter-operator");
		
		if( $("option", that).length != 0 ) {
			return;
		}
		
		Aimeos.Filter.promise.done(function(data) {
			var code = that.data("selected");

			$.each(data.meta && data.meta.attributes || {}, function(key, attr) {
				if( attr.public && attr.code === code ) {
					that.append('<option value=' + attr.code + ' selected="selected">' + attr.label + '</option>');
				} else if( attr.public ) {
					that.append('<option value=' + attr.code + '>' + attr.label + '</option>');
				}
			});

			if( code && data.meta && data.meta.attributes && data.meta.attributes[code] ) {
				$("option." + data.meta.attributes[code].type, opitem).show();
			}
			
			that.selectmenu("refresh");
		});
	},
	
	
	selectKeys : function(e, ui) {

		var opitem = $(this).parents(".filter-item").find(".filter-operator");
		$("option", opitem).hide().removeProp("selected");

		Aimeos.Filter.promise.done(function(data) {

			if( data.meta && data.meta.attributes && data.meta.attributes[ui.item.value] && data.meta.attributes[ui.item.value].type ) {
				var options = $("option." + data.meta.attributes[ui.item.value].type, opitem)
				options.first().prop("selected", "selected");
				options.show();
			}
		});
	},

	
	addFilterKeys : function() {

		$( ".aimeos .filter-item .filter-key" ).selectmenu({
			select: Aimeos.Filter.selectKeys,
			create: Aimeos.Filter.addKeys
		});
	},

	
	addFilterItem : function() {

		$(".aimeos .filter-items").on("click", ".fa-plus", function(e) {
			var proto = $(".prototype", e.delegateTarget);
			var clone = proto.clone().insertBefore(proto);
	
			$("input,select", clone).prop("disabled", false);
			clone.removeClass("prototype").addClass("filter-item");
			$(this).removeClass("fa-plus").addClass("fa-minus");
	
			$(".filter-key", clone).selectmenu({
				select: Aimeos.Filter.selectKeys,
				create: Aimeos.Filter.addKeys
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
	},
};



Aimeos.Item = {

	init : function() {
		
		Aimeos.Item.addConfigLine();
		Aimeos.Item.deleteConfigLine();
		Aimeos.Item.setupConfigComplete();
		Aimeos.Item.createDatePicker();
		Aimeos.Item.checkMandatory();
	},
	
	
	addConfigLine : function() {
		
		$(".aimeos .item-config").on("click", ".fa-plus", function(ev) {
			var line = $(".prototype", ev.delegateTarget);
			var clone = line.clone();
			
			clone.insertBefore(line).removeClass("prototype");
			$("input", clone).prop("disabled", false);
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
	
	
	setupConfigComplete : function() {
		
		$(".aimeos .config-item .config-key").autocomplete({
			source: ['css-class'],
			minLength: 0,
			delay: 0
		});

		$(".aimeos .item").on("click", " .config-key", function(ev) {
			$(this).autocomplete("search", "");
		});
	},
	

	checkMandatory : function() {
		
		$(".aimeos .item .mandatory").on("blur", "input,select", function(ev) {

			if($(this).val() != '') {
				$(ev.delegateTarget).removeClass("has-danger").addClass("has-success");
			} else {
				$(ev.delegateTarget).removeClass("has-success").addClass("has-danger");
			}
		});


		$(".aimeos form").on("submit", function(ev) {
			var retval = true;
			var nodes = [];

			$(".card-header", this).removeClass("has-danger");

			$(".mandatory", this).each(function(idx, element) {
				var elem = $(element);
				var value = elem.find("input,select").val();

				if(value === null || value.trim() === "") {
					elem.addClass("has-danger");
					nodes.push(element);
					retval = false;
				} else {
					elem.removeClass("has-danger");
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
	}
};



Aimeos.Item.Bundle {

	init : function() {

		Aimeos.Item.Bundle.addLine();
		Aimeos.Item.Bundle.deleteLine();
	},


	addLine : function() {

		$(".product-item-bundle").on("click", ".fa-plus", function(ev) {
			var line = $(".prototype", ev.delegateTarget);
			var clone = line.clone();

			clone.insertBefore(line).removeClass("prototype");
			$(".combobox-prototype", clone).removeClass("combobox-prototype").addClass("combobox").selectmenu();
		});
	},


	removeLine : function() {

		$(".product-item-bundle").on("click", ".fa-trash", function() {
			var elem = $(this);

			$("#confirm-delete").modal();
			$("#confirm-delete").on('click', ".btn-danger", function(e) {
				$(e.delegateTarget).modal('hide');
				elem.parents("tr").remove();
			});
		});
	}
};



$(function() {
	
	Aimeos.Common.init();
	Aimeos.Filter.init();

	Aimeos.Item.init();
	Aimeos.Item.Bundle.init();
});
