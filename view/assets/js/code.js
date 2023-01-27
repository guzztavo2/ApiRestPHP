window.onload = function () {

    console.log(window.location.href.split('/'));
    if (window.location.href.split('/')[3] === HOME_PATH.split('/')[3] && window.location.href.split('/')[4] !== 'produtos')
        new main();
    else if(window.location.href.split('/')[3] === HOME_PATH.split('/')[3] && window.location.href.split('/')[4] === 'produtos'){
    
    }


}






class main {

    constructor() {
        this.buttonsEventsOnload();
        this.setTimeHome();
    }
    setTimeHome() {
        ultimaVezExecutado();

        function ultimaVezExecutado() {
            setDate(document.querySelector('#ultimaVezExecutado'));
            setDate(document.querySelector('#tempoOnline'));
            subsDate(document.querySelector('#proximaExecucao'));
        }

        function subsDate(ultimaVezBtn) {
            if (ultimaVezBtn.innerHTML.trim() !== 'Ainda não foi executado') {
                let time = ultimaVezBtn.innerHTML;
                
                time = time.trim();
                let date = new Date();
                time = time.split('/');
                date.setHours(time[0], time[1], time[2]);
                ultimaVezBtn.innerHTML = date.getHours() + ' horas, ' + date.getMinutes() + ' minutos, ' + date.getSeconds() + ' segundos.'

                setInterval(() => {
                    let segundos = date.getSeconds();
                    --segundos;
                    date.setSeconds(segundos)
                    ultimaVezBtn.innerHTML = date.getHours() + ' horas, ' + date.getMinutes() + ' minutos, ' + date.getSeconds() + ' segundos.'
                }, 1000);
            }
        }
        function setDate(ultimaVezBtn) {
            
            if (ultimaVezBtn.innerHTML.trim() !== 'Ainda não foi executado') {
                let time = ultimaVezBtn.innerHTML;
                time = time.trim();
                let date = new Date();
                time = time.split('/');
                date.setHours(time[0], time[1], time[2]);
                ultimaVezBtn.innerHTML = date.getHours() + ' horas, ' + date.getMinutes() + ' minutos, ' + date.getSeconds() + ' segundos.'

                setInterval(() => {
                    let segundos = date.getSeconds();
                    ++segundos;
                    date.setSeconds(segundos)
                    ultimaVezBtn.innerHTML = date.getHours() + ' horas, ' + date.getMinutes() + ' minutos, ' + date.getSeconds() + ' segundos.'
                }, 1000);
            }
        }
    }



    buttonsEventsOnload() {
        btnExecuteCRON();
        function btnExecuteCRON() {
            
            let btn = document.querySelector('#btnExecute');
            if(btn === null)
            return;
            btn.onclick = function () {
                let promise = new Promise(resolve => {
                    let xhr = new XMLHttpRequest();
                    xhr.open('PUT', HOME_PATH + 'CronUpdateWindowsTask');
                    xhr.onloadstart = function () {
                        btn.innerHTML = 'Carregando, aguarde por favor.';
                        btn.setAttribute('style', 'cursor:progress');
                        document.querySelectorAll('button div header').forEach(item => {
                            item.classList.add('placeholder');
                        })
                    }
                    xhr.onloadend = function () {
                        btn.innerHTML = 'Finalizado!';
                        btn.setAttribute('style', 'cursor:pointer');
                        console.log(xhr.response);
                        document.querySelectorAll('button div header').forEach(item => {
                            item.classList.remove('placeholder');
                        })
                        resolve('finalizado');
                    }
                    xhr.send();
        
        
                }).then((data) => {
                    alert('Tudo certo, recarregaremos a página para concluir tudo com sucesso!');
                    window.location.href = window.location.href;
                })
            }
        }
    }





}



