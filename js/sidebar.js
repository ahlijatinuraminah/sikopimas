<script>
$(document).ready(function(){
    // Display alert message after toggling paragraphs
    $(".toggle-btn").click(function(){
        $("p").toggle(1000, function(){
            // Code to be executed
            alert("The toggle effect is completed.");
        });
    });
});
</script>