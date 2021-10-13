function alertModal(msg, titulo='Atenção', reload=false){

   

    htmlModal = '<div class="bg-light text-dark bg-modal" id="DivAlert">'
    htmlModal += '<div class="modal fade bg-light text-dark" id="modalAlert" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAlertLabel" aria-hidden="true">'
    htmlModal += '<div class="modal-dialog modal-dialog-centered">'
    htmlModal += '<div class="modal-content">'
    htmlModal += '<div class="modal-header">'
    htmlModal += '<h6 class="modal-title">'+titulo+'</h6>'
    htmlModal += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'
    htmlModal += '</div>'
    htmlModal += '<div class="modal-body">'
    htmlModal += '<div class="container">'
    htmlModal += '<div id="alertMSG">'+msg+'</div>'
    htmlModal += '</div></div>'
    htmlModal += '<div class="modal-footer">'
    htmlModal += '<button class="btn btn-primary btn-Alert" data-bs-dismiss="modal">OK</button>'
    htmlModal += '</div></div></div></div></div>'
    
    $(function(){

       $("body").append(htmlModal);
       $("#modalAlert").modal("show");
       
       if(reload === true){
            $('.btn-Alert').click(function() {
                document.location.reload(true)
            })
            $('.btn-close').click(function() {
                document.location.reload(true)
            })
        } else if(reload === false){
           
            $('.btn-Alert').click(function() {
                $('#DivAlert').remove();
            })
            $('.btn-close').click(function() {
                $('#DivAlert').remove();
            })
        } else {
            $('.btn-Alert').click(function() {
                document.location.href = reload; 
            })
            $('.btn-close').click(function() {
                document.location.href = reload; 
            })
             
        }
      
      });

}