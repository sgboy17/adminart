$(document).ready(function() {
    //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'popup';     
    
    //make username editable
    $('#x-01').editable();
    $('#x-02').editable();
    $('#x-03').editable();
    $('#x-04').editable();
    $('#x-05').editable();
    $('#x-06').editable();
    $('#x-07').editable();
    $('#x-08').editable();
    $('#x-09').editable();
    $('#x-10').editable();
    $('#x-11').editable();
    $('#x-12').editable();
    $('#x-13').editable();
    $('#x-14').editable();
    $('#x-15').editable();
    $('#x-16').editable();
    $('#x-17').editable();
    $('#x-18').editable();
    $('#x-19').editable();
    $('#x-20').editable();
    
    //make status editable
    $('#metric-01').editable({
        type: 'select',
        title: 'Select status',
        placement: 'right',
        value: 2,
        source: [
            {value: 1, text: 'hr'},
            {value: 2, text: 'km'},
        ]
        /*
        //uncomment these lines to send data on server
        ,pk: 1
        ,url: '/post'
        */
    });
    
    //make status editable
    $('#metric-02').editable({
        type: 'select',
        title: 'Select status',
        placement: 'right',
        value: 2,
        source: [
            {value: 1, text: 'hr'},
            {value: 2, text: 'km'},
        ]
        /*
        //uncomment these lines to send data on server
        ,pk: 1
        ,url: '/post'
        */
    });
    
    //make status editable
    $('#metric-03').editable({
        type: 'select',
        title: 'Select status',
        placement: 'right',
        value: 2,
        source: [
            {value: 1, text: 'hr'},
            {value: 2, text: 'km'},
        ]
        /*
        //uncomment these lines to send data on server
        ,pk: 1
        ,url: '/post'
        */
    });
    
    //make status editable
    $('#metric-04').editable({
        type: 'select',
        title: 'Select status',
        placement: 'right',
        value: 2,
        source: [
            {value: 1, text: 'hr'},
            {value: 2, text: 'km'},
        ]
        /*
        //uncomment these lines to send data on server
        ,pk: 1
        ,url: '/post'
        */
    });
});

$(function(){
    $('#knowledge-date').editable({
        format: 'DD-MM-YYYY',    
        viewformat: 'DD.MM.YYYY',    
        template: 'D / MMMM / YYYY',    
        
    });
});


$(function(){
    $('#history-date').editable({
        format: 'DD-MM-YYYY',    
        viewformat: 'DD.MM.YYYY',    
        template: 'D / MMMM / YYYY',    
        
    });
});

$(function(){
    //local source
    $('#specific-popup').editable({
        source: [
              {id: 'gb', text: 'Conveyor Belt Part'},
              {id: 'us', text: 'Another Belt Part'},
              {id: 'ru', text: 'Bottom part of the machine'}
           ],
        select2: {
           multiple: false
        }
    });
});
$(function(){
    //local source
    $('#author-popup').editable({
        select2: {
           maximumSelectionSize: 1,
		  allowClear: true,
		  tags:["Pedro Banales", "Yunus Ozmen", "John Citizen", "David Doe" ],
		  placeholder: "Select or create a user",
        }
    });
});
		