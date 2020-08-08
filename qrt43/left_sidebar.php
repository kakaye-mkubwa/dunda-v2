<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
<!--            <img src="images/user.png" width="48" height="48" alt="User" />-->
            <img src="<?=$bloggerDetails['image_url']?>" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$bloggerDetails['first_name'].' '.$bloggerDetails['last_name']?></div>
            <div class="email"><?=$bloggerDetails['email']?></div>

        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active">
                <a href="index.php">
                    <i class="material-icons">home</i>
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="manage-posts.php">
                    <i class="material-icons">layers</i>
                    <span>Manage</span>
                </a>
            </li>
            <li>
                <a href="add-post.php">
                    <i class="material-icons">note_add</i>
                    <span>Add Post</span>
                </a>
            </li>
            <li>
                <a href="sign-out.php">
                    <i class="material-icons">input</i>
                    <span>Sign Out</span>
                </a>
            </li>

        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; <span id="year"></span> <a href="javascript:void(0);">Dunda Football - Material Design</a>.
        </div>
        <div class="version">
            <b>Version: </b> 2.0.5
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->
<script>
    document.getElementById("year").innerHTML = new Date().getFullYear();
</script>