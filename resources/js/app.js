
const element = document.getElementById('hh');
element.addEventListener('click',
    () => {
        updatePost();
});

function updatePost(){
    const socket = new WebSocket(`ws://localhost:6001/socket`);
    socket.onopen = function (event){
        console.log('On open');
    }
}