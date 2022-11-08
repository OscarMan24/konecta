const switchButton = document.getElementById('switch');
 
if (switchButton != null) {
    switchButton.addEventListener('click', () => {
        cambiar();
    });
}


function readCookie(name) {
    var nameEQ = name + "="; 
    var ca = document.cookie.split(';');  
    for(var i=0;i < ca.length;i++) {  
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) {
        return decodeURIComponent( c.substring(nameEQ.length,c.length) );
      }  
    }  
    return null;  
}

function cambiar(){
    var lasCookies = readCookie("dark_mode");

    if (lasCookies == null) {
        // document.cookie="dark_mode=desactive;";
        document.cookie="dark_mode=active;";
    } else {
        if (lasCookies == 'active') {
            document.cookie="dark_mode=desactive;";
        }else if(lasCookies == 'desactive'){
            document.cookie="dark_mode=active;";
        }
    }    
    document.body.classList.toggle('dark'); //toggle the HTML body the class 'dark'
    switchButton.classList.toggle('active');//toggle the HTML button with the id='switch' with the class 'active'
}

$(window).on("load", function () {
    var lasCookies = readCookie("dark_mode");
    if (lasCookies == null) {
        document.cookie="dark_mode=desactive;";
    } else {
        if (lasCookies == 'active') {
            document.body.classList.add('dark');
            if (switchButton != null) {
                switchButton.classList.add('active');
            } 
          
        }else if(lasCookies == 'desactive'){
            document.body.classList.remove('dark'); 
            if (switchButton != null) {
                switchButton.classList.remove('active');
            }            
        }
    }
    
   
    var installButton = document.getElementById('addtohome');
    var defferedPrompt;
    window.addEventListener("beforeinstallprompt", (beforeInstallPromptEvent) => {
        beforeInstallPromptEvent.preventDefault(); // Prevents immediate prompt display
    
        // Shows prompt after a user clicks an "install" button
        installButton.addEventListener("click", (mouseEvent) => {
        // you should not use the MouseEvent here, obviously
        beforeInstallPromptEvent.prompt();
        });
    
        installButton.hidden = false; // Make button operable
    });
    window.addEventListener('appinstalled', () => {
        hideInstallPromotion();
        defferedPrompt = null;
        document.getElementById('toastinstall').style.display = 'none';
        let timerInterval
            Swal.fire({
                icon :'success',
                title: '¡Instalado correctamente!',
                text: 'Gracias por instalar nuestra web',
                timer: 1500,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            })
            
    });
});
