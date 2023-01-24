window.onload = function () {
    new main();



}






class main {

    constructor() {
        this.buttonsEventsOnload();
    }




    buttonsEventsOnload() {
        btnExecuteCRON();

    }





}




function btnExecuteCRON() {
    let btn = document.querySelector('#btnExecute');

    btn.onclick = function () {
        let promise = new Promise(resolve => {
            let xhr = new XMLHttpRequest();
            xhr.open('PUT', 'http://localhost/Projeto/CronUpdateWindowsTask');
            xhr.onloadstart = function () {
                console.log('carregando')
            }
            xhr.onloadend = function () {
                console.log('finalizazndo')
                resolve(xhr.response);
            }
            xhr.send();


        }).then((data) => {
            console.log(data);
        })
    }
}