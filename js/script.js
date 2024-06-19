let msgdiv=document.querySelector(".msg");
let msgroom=document.querySelector(".room_id").value;

setInterval(() => {
  fetch(`readMsg.php?room=${msgroom}`).then(
    r=>{
     if(r.ok){
      return r.text();
     }
    }
  ).then(
    d=>{
      msgdiv.innerHTML=d;
    }
  )
}, 500);


window.onkeydown=(e)=>{
  if(e.key=="Enter"){
    update()
  }
}
function update(){
  let msg=input_msg.value;
  input_msg.value="";
  fetch(`addMsg.php?msg=${msg}&&room=${msgroom}`).then(
    r=>{
      if(r.ok){
        return r.text();
      }
    }
  ).then(
    d=>{
     // console.log("gotovo")
      msgdiv.scrollTop=(msgdiv.scrollHeight-msgdiv.clientHeight);
    }
  )
}

//модальное окно
$(function () {
  $('#callback-button, #callback-button2').click(function (e) {
    e.preventDefault();
    $('.modal').addClass('modal_active');
    $('body').addClass('hidden');
  });

  $('.modal__close-button').click(function (e) {
    e.preventDefault();
    $('.modal').removeClass('modal_active');
    $('body').removeClass('hidden');
  });  

  $('.modal').mouseup(function (e) {
    let modalContent = $(this).find(".modal__content, .modal__content2");
    if (!modalContent.is(e.target) && modalContent.has(e.target).length === 0) {
      $(this).removeClass('modal_active');
      $('body').removeClass('hidden');
    }
  });
});

// удаление сообщений
function deleteMessage(message_id) {
  if (confirm('Вы уверены, что хотите удалить это сообщение?')) {
    var xhr = new XMLHttpRequest();
    console.log(message_id);
    xhr.open('POST', '../delete_msg.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(this.response);
        alert(response.message); // Alert the response from the backend
      }
    };
    xhr.send('message_id=' + message_id);
  }
}