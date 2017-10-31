/**
 * SimpleDualListbox script
 *
 *
 * @author Edwin Artunduaga <edwinhaq@gmail.com>
 * @copyright Copyright &copy; 2017 Edwin Artunduaga
 * @license BSD
 *
 * @link https://github.com/edwinhaq/yii2-simple-dual-listbox
 *
 */
;
(function($)
{
	var pluginName = 'simple-dual-listbox';
	$.fn.listboxdual = function(options, data)
	{
		var settings = $.extend({}, $.fn.listboxdual.defaults, options);
		addRemoveElement(this, data, settings);
		return this;
	};
	$.fn.listboxdual.defaults = {
		availableListboxPosition : "left",
		upButtonText : "UP",
		addButtonText : "ADD",
		addAllButtonText : "ADDALL",
		remAllButtonText : "REMALL",
		remButtonText : "REM",
		downButtonText : "DOWN",
		selectedLabel : "Selected",
		availableLabel : "Available"
	};
	function addRemoveElement(element, data, settings)
	{
		var id_dst = element.attr("id");
		var id_src = id_dst + "_all";
		var dst = "#" + id_dst;
		var src = "#" + id_src;
		var gen_button = $("<button>").addClass("simple-dual-listbox-button btn btn-default");
		var button_up = gen_button.clone().attr("id", "up_" + id_dst).text(settings.upButtonText);
		var button_down = gen_button.clone().attr("id", "down_" + id_dst).text(settings.downButtonText);
		var button_add = gen_button.clone().attr("id", "add_" + id_dst).text(settings.addButtonText);
		var button_addall = gen_button.clone().attr("id", "addall_" + id_dst).text(settings.addAllButtonText);
		var button_del = gen_button.clone().attr("id", "del_" + id_dst).text(settings.remButtonText);
		var button_delall = gen_button.clone().attr("id", "delall_" + id_dst).text(settings.remAllButtonText);
		var availableListBox = element.clone();
		availableListBox.attr("id", id_src).empty();
		availableListBox.removeAttr("name");
		$.each(data, function(key, value)
		{
			availableListBox.append($("<option>").attr("value", key).attr("title", value).text(value));
		});
		clone = $(dst).clone(true);
		if(settings.availableListboxPosition != "left"){
			right_listbox = availableListBox;
			left_listbox = clone;
			right_label = settings.availableLabel;
			left_label = settings.selectedLabel;
		}else{
			right_listbox = clone
			left_listbox = availableListBox;
			right_label = settings.selectedLabel;
			left_label = settings.availableLabel;
		}
		table = $("<table>").attr("id", "table_simple_dual_listbox_" + id_dst).addClass("simple-dual-listbox-table");
		table.mouseleave(function()
		{
			$("#" + id_dst).children("option").each(function()
			{
				$(this).prop('selected', true);
			});
		});
		row = $("<tr>");
		left_column = $("<div>").addClass("simple-dual-listbox-div-left");
		left_column.append($("<label>").addClass("control-label").text(left_label));
		left_column.append(left_listbox);
		buttons_column = $("<div>").addClass("btn-group-vertical simple-dual-listbox-div-buttons").attr("role", "group").attr("aria-label", "...");
		buttons_column.append(button_up);
		buttons_column.append(button_add);
		buttons_column.append(button_addall);
		buttons_column.append(button_delall);
		buttons_column.append(button_del);
		buttons_column.append(button_down);
		right_column = $("<div>").addClass("simple-dual-listbox-div-right");
		right_column.append($("<label>").addClass("control-label").text(right_label));
		right_column.append(right_listbox);
		row.append($("<td>").append(left_column));
		row.append($("<td>").append(buttons_column));
		row.append($("<td>").append(right_column));
		table.append($("<tbody>").append(row));
		$(dst).replaceWith(table);
		button_up.click(function()
		{
			$(dst + " option:selected").each(function()
			{
				var newPos = $(dst + " option").index(this) - 1;
				if(newPos > -1){
					$(dst + " option").eq(newPos).before("<option title=\'" + $(this).attr("title") + "\' value=\'" + $(this).val() + "\' selected=\'selected\'>" + $(this).text() + "</option>");
					$(this).remove();
				}
			});
			return false;
		});
		button_down.click(function()
		{
			var countOptions = $(dst + " option").size();
			$(dst + " option:selected").each(function()
			{
				var newPos = $(dst + " option").index(this) + 1;
				if(newPos < countOptions){
					$(dst + " option").eq(newPos).after("<option title=\'" + $(this).attr("title") + "\' value=\'" + $(this).val() + "\' selected=\'selected\'>" + $(this).text() + "</option>");
					$(this).remove();
				}
			});
			return false;
		});
		button_add.click(function()
		{
			listbox_dual_add(src, dst, false);
			return false;
		});
		button_addall.click(function()
		{
			listbox_dual_add(src, dst, true);
			return false;
		});
		button_del.click(function()
		{
			listbox_dual_remove(src, dst, false);
			return false;
		});
		button_delall.click(function()
		{
			listbox_dual_remove(src, dst, true);
			return false;
		});
		return element;
	}
	function listbox_dual_add(src, dst, all)
	{
		if(all){
			$(src + " option").prop('selected', true);
		}
		var vals = [];
		var text = [];
		var titles = [];
		$(src + " :selected").each(function(i, selected)
		{
			vals[i] = $(selected).val();
			text[i] = $(selected).text();
			titles[i] = $(selected).attr("title");
		});
		var i = 0;
		for(i = 0;i < vals.length;i++){
			$(src + " option[value = \'" + vals[i] + "\']").remove();
			$(dst).append($("<option>").attr("title", titles[i]).attr("value", vals[i]).text(text[i]))
		}
		$(dst + " option").attr("selected", true);
		$(src + " option").attr("selected", true);
	}
	function listbox_dual_remove(src, dst, all)
	{
		listbox_dual_add(dst, src, all);
	}
}(jQuery));