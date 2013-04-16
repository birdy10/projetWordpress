jQuery(window).load(function() {
    jQuery(function() {
        Grid.init();
    });
});


var $i = 0;

$(window).on('hashchange', function() {
	$i++;

	if($i < 2)
	{
		var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
    	callAjax(hash);
	}
	else
	{
		alert('vous avez déjà voté pour une technologie !');
	}
	
});


function callAjax(id){
	jQuery.ajax({
		type: "POST",
		data: {data:id},
        url: 'http://wordpress.etuwebdev.fr/wp-content/plugins/graph/addVote.php',
        success: function(data) {
            alert('Votre vote a été pris en compte !');
        },
        error: function(error) {
            console.log(error);
        },
        cache: false
    });
}

