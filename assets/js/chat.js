document.addEventListener("DOMContentLoaded", function () {
  const userList = document.getElementById("userList");
  const chatBox = document.getElementById("chatBox");
  const messageInput = document.getElementById("messageInput");
  const sendBtn = document.getElementById("sendBtn");
  const chatUserImage = document.getElementById("chatUserImage");
  const chatUserName = document.getElementById("chatUserName");
  const chatUserStatus = document.getElementById("chatUserStatus");
  let currentUser = null;
  let usersCache = {};

  function loadUsers() {
    fetch("fetch_users.php")
      .then((res) => res.json())
      .then((users) => {
        userList.innerHTML = "";
        usersCache = {};
        users.forEach((u) => {
          usersCache[u.id] = u;
          const li = document.createElement("li");
          li.className =
            "list-group-item d-flex justify-content-between align-items-center";
          li.textContent = u.name;
          const badge = document.createElement("span");
          badge.className =
            "badge rounded-pill " + (u.online ? "bg-success" : "bg-secondary");
          badge.textContent = u.online ? "Online" : "Offline";
          li.appendChild(badge);
          li.onclick = () => {
            currentUser = u.id;
            setChatHeader(u);
            loadMessages();
          };
          userList.appendChild(li);
        });
        if (currentUser && usersCache[currentUser]) {
          setChatHeader(usersCache[currentUser]);
        }
      });
  }

  function loadMessages() {
    if (!currentUser) return;
    fetch("fetch_messages.php?user_id=" + currentUser)
      .then((res) => res.json())
      .then((msgs) => {
        chatBox.innerHTML = "";
        msgs.forEach((m) => {
          const div = document.createElement("div");
          div.className =
            m.sender_id == myId ? "message sent" : "message received";
          div.innerHTML = `<div class="bubble">${m.message}</div>`;
          chatBox.appendChild(div);
        });
        chatBox.scrollTop = chatBox.scrollHeight;
      });
  }

  // function loadMessages() {
  //     if (!currentUser) return;
  //     fetch('fetch_messages.php?user_id=' + currentUser)
  //         .then(res => res.json())
  //         .then(msgs => {
  //             chatBox.innerHTML = '';
  //             msgs.forEach(m => {
  //                 const div = document.createElement('div');
  //                 div.className = (m.sender_id == myId ? 'text-end mb-2' : 'text-start mb-2');
  //                 div.innerHTML = '<span class="badge bg-' + (m.sender_id == myId ? 'primary' : 'light text-dark') + '">' + m.message + '</span>';
  //                 chatBox.appendChild(div);
  //             });
  //             chatBox.scrollTop = chatBox.scrollHeight;
  //         });
  // }

  function sendMessage() {
    const text = messageInput.value.trim();
    if (!text || !currentUser) return;
    const fd = new FormData();
    fd.append("receiver_id", currentUser);
    fd.append("message", text);
    fetch("send_message.php", { method: "POST", body: fd })
      .then((res) => res.text())
      .then(() => {
        messageInput.value = "";
        loadMessages();
      });
  }

  sendBtn.addEventListener("click", sendMessage);
  messageInput.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      sendMessage();
    }
  });

  function updateStatus() {
    fetch("update_last_active.php");
  }

  function setChatHeader(u) {
    chatUserImage.src = u.profile_image;
    chatUserName.textContent = u.name;
    if (u.online) {
      chatUserStatus.textContent = "Online";
    } else if (u.last_active) {
      const d = new Date(u.last_active);
      chatUserStatus.textContent = "Last seen " + d.toLocaleString();
    } else {
      chatUserStatus.textContent = "Offline";
    }
  }

  setInterval(() => {
    loadUsers();
    if (currentUser) loadMessages();
    updateStatus();
  }, 5000);

  loadUsers();
  updateStatus();
});
