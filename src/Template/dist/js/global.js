class Global {
        constructor() {
            this.recoverMenuActiveLink();
            this.MenuActiveLink();
            this.defaultAjaxSetupLoading();
        }

        introJsPTBR()
        {
            introJs().setOptions({
                    nextLabel: ' > ',
                    prevLabel: ' < ',
                    doneLabel: ' Fechar ',
                    scrollTo: 'tooltip',
                    showProgress: true,
                    showBullets: true,
                    showButtons: true,
                    keyboardNavigation: true,
                    showStepNumbers: false,
                    exitOnEsc: true
                }).start();
        }

        defaultAjaxSetupLoading(){
            $.ajaxSetup({
                beforeSend: function(xhr) {
                    _global.startLoading()
                },
                complete: function(xhr,status) {
                    _global.stopLoading()
                }
            });
        }

        startLoading()
        {
            $(".overlay-loader").show();
        }

        stopLoading(){
            $(".overlay-loader").hide();
        }

        recoverMenuActiveLink()
        {
            const itemsMenu = document.querySelectorAll(".nav-link");
            if(!!sessionStorage.getItem("menu"))
            {
                var menu = sessionStorage.getItem("menu");
                if(itemsMenu.length)
                {
                    itemsMenu[menu].classList.add("active")
                    itemsMenu[menu].parentElement.classList.add("menu-is-opening")
                    itemsMenu[menu].parentElement.classList.add("menu-open")
                }
            }
            if(!!sessionStorage.getItem("subMenu"))
            {
                var subMenu = sessionStorage.getItem("subMenu")
                if(itemsMenu.length)
                    itemsMenu[subMenu].classList.add("active")
            }
        }

        MenuActiveLink()
        {
            const itemsMenu = document.querySelectorAll(".nav-item");
            itemsMenu.forEach((item,index) => {
                item.addEventListener("click", () => {
                    const itemsMenu2 = document.querySelectorAll(".nav-item");
                    itemsMenu2.forEach(item2 => {
                        item2.classList.remove("active");
                    })
                    sessionStorage.removeItem("menu");
                    sessionStorage.setItem("menu",index);
                    item.classList.add("active");
                })
            })

            const itemsSubMenu = document.querySelectorAll(".nav-link");
            itemsSubMenu.forEach((item,index) => {
                item.addEventListener("click", () => {
                    const itemsSubMenu2 = document.querySelectorAll(".nav-link");
                    itemsSubMenu2.forEach(item2 => {
                        item2.classList.remove("active");
                    })
                    sessionStorage.removeItem("subMenu");
                    sessionStorage.setItem("subMenu",index);
                    item.classList.add("active");
                })
            })
        }
}

var _global;

$(document).ready(() => {
    _global = new Global();
})