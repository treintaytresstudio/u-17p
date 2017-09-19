<?php include 'includes/header.php'; ?>

<div class="full">
    
<div class="settings">
    <form class="form">
        <div class="form-item">
            <div class="settings-pp avatar"></div>
            <label for="exampleFormControlFile1">Change Profile Image</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1">
        </div>
        <div class="form-item">
            <label for="username">Name</label>
            <input class="form-control input-accent" type="text" placeholder="Name" name="screenName">
        </div>
        <div class="form-item">
            <label for="username">Email</label>
            <input class="form-control input-accent" type="text" placeholder="Email" name="screenName">
        </div>
        <div class="form-item">
            <label for="username">Username</label>
            <input class="form-control input-accent" type="text" placeholder="Username" name="username">
        </div>
        <div class="form-item">
            <label for="exampleFormControlTextarea1">Bio</label>
            <textarea class="form-control input-accent" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="form-item">
            <label for="country">Country</label>
            <select class="form-control input-accent">
                <option>Default select</option>
            </select>
        </div>
        <div class="form-item--space">
		    <input type="submit" class="btn btn-primary btn-lg btn-block bg-accent" name="signup" value="Update">
		</div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>