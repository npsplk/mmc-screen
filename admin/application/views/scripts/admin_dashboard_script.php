<script>
    jQuery(document).ready(function ($) {

        function save_settings()
        {
            localStorage.setItem("background_color", $("#background_color").val());
            localStorage.setItem("text_color", $("#text_color").val());
            localStorage.setItem("text_size", $("#text_size").val());
            localStorage.setItem("theme_name", $("#theme_name").val());
            localStorage.setItem("icon_label", $('input[name="icon_label"]:checked').val());
            apply_preferences_to_page();
        }


        function load_settings()
        {
            var background_color = localStorage.getItem("background_color");
            var text_color = localStorage.getItem("text_color");
            var text_size = localStorage.getItem("text_size");
            var theme_name = localStorage.getItem("theme_name");
            var icon_label = localStorage.getItem("icon_label");
            $("#background_color").val(background_color);
            $("#text_color").val(text_color);
            $("#text_size").val(text_size);
            $("#theme_name").val(theme_name);
            $("#icon_label").val(icon_label);
            apply_preferences_to_page();
        }


        function apply_preferences_to_page()
        {
            var background_color = localStorage.getItem("background_color");
            var text_color = localStorage.getItem("text_color");
            var text_size = localStorage.getItem("text_size");
            var theme_name = localStorage.getItem("theme_name");
            var stored_icon_label = localStorage.getItem("icon_label");
            $("body").css("backgroundColor", background_color);
            $("body").css("color", $("#text_color").val());
            $("body").css("fontSize", $("#text_size").val() + "px");
            $("body").attr("class", theme_name);
//                            $('link[title="theme"]').attr('href', 'http://netdna.bootstrapcdn.com/bootswatch/3.0.3/' + theme_name + '/bootstrap.min.css');
            $(".current-theme").html(theme_name);
            $(".label-filter").html(theme_name);
            if (stored_icon_label == "Yes")
            {
                $(".icon_label").show();
            }

            if (stored_icon_label == "No")
            {
                $(".icon_label").hide();
            }

            display_preferences();
        }


        function display_preferences()
        {
            //the variable that will hold the results
            var dataLog = "";
            var i = 0;
            //how many items are in the database starting with zero
            var logLength = localStorage.length - 1;
            dataLog = "<thead><tr class='active'><th>Item Name</th><th>Item Data</th></tr></thead><tbody>"

            //now we are going to loop through each item in the database
            for (i = 0; i <= logLength; i++) {
                //lets setup some variables for the key and values
                var itemKey = localStorage.key(i);
                var itemData = localStorage.getItem(itemKey);
                //now that we have the item, lets add it to the table
                dataLog += '<tr><td>' + itemKey + '</td><td>' + itemData + '</td></tr>';
            }

            //if there were no items in the database
            if (dataLog == "")
                dataLog = '<li class="empty">Log Currently Empty</li>';
            //update the ul with the list items
            $("#theLog").html(dataLog);
        }


        $(function ()
        {
            load_settings();
            $('form#preferences').submit(function (event) {
                event.preventDefault();
                save_settings();
            });
        });
    });
</script>

