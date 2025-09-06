<?php
include 'includes/auth.php';
include 'config.php';
?>
<?php include 'includes/common-header.php'; ?>

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Chat</h4>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-md-4">
                    <ul id="userList" class="list-group"></ul>
                </div>
                <div class="col-md-8">
                    <div id="chatBox" style="height:400px; overflow-y:auto; border:1px solid #dee2e6; padding:10px; margin-bottom:10px;"></div>
                    <div class="input-group">
                        <input type="text" id="messageInput" class="form-control" placeholder="Type a message">
                        <button class="btn btn-primary" id="sendBtn"></button>
                    </div>
                </div>
            </div> -->

        </div>
        <!-- container-fluid -->

        <div class="container-fluid p-3">
            <div class="row chat-wrapper">
                <div class="col-md-4 border-end p-0">
                    <div class="bg-light h-100">
                        <h5 class="p-3">Chats</h5>
                        <ul id="userList" class="list-group list-group-flush">
                        </ul>
                    </div>
                </div>
                <div class="col-md-8 d-flex flex-column">
                    <div class="chat-header">
                        <div class="d-flex align-items-center">
                            <img id="chatUserImage" src="assets/images/users/avatar-1.jpg" alt="" class="rounded-circle">
                            <div>
                                <div><strong id="chatUserName">Select a user</strong></div>
                                <small id="chatUserStatus"></small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="header-icons">
                                <img src="assets/icons/telephone.png" />
                            </div>
                            <div class="header-icons">
                                <img src="assets/icons/video-call.png" />
                            </div>
                        </div>
                    </div>
                    <div id="chatBox" class="flex-grow-1"></div>
                    <div class="chat-footer d-flex align-items-center">
                        <input type="text" id="messageInput" class="form-control" placeholder="Type a message">
                        <button class="btn btn-primary" id="sendBtn">
                            <img src="assets/icons/sending.png" width="16" />
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Page-content -->

    <?php include 'includes/footer.php'; ?>
</div>
<!-- end main content-->

<script>const myId = <?php echo (int) $_SESSION['user_id']; ?>;</script>
<script src="assets/js/chat.js"></script>
<?php include 'includes/common-footer.php'; ?>