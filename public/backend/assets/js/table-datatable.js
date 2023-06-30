$(function() {
	"use strict";

    $(document).ready(function() {
        $('#example').DataTable({
            "order":[],
            "aaSorting": []
        });
      } );


      $(document).ready(function() {
        var table = $('#example2').DataTable( {
            "order": [],
            "aaSorting":[]

        } );
    } );


});
