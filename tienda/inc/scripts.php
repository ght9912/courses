<script src="vendors/bootstrap/bootstrap.bundle.min.js"></script>
<script src="vendors/jquery/jquery-3.6.0.js"></script>
<script src="vendors/currency/currency.min.js"></script>
<script type="text/javascript" src="vendors/DataTables/datatables.js"></script>


<script type="text/javascript">
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
    
    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
    $("#btnLogOut").click((e)=>{
        e.preventDefault();
        let fd={
        action:"logout",
   
    }
    $.ajax({
                type: "POST",
                url: "controllers/usuarios.php",
                data: fd,
                success: function (response) {
                    window.location="login.php";
                },
                error: function(jqHXR,textStatus,errorThrow){
                    console.log(jqHXR,textStatus,errorThrow);
                }
            });
    })
</script>