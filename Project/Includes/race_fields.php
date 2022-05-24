
<div class="profile-group">
    <div class="profile-label">
        <h3>Race Name</h3>
    </div>    
    <div class="profile-data">
        <input type="text" name="raceName" value="<?php if(isset($row['race_id'])) {echo $row['race_name']; } ?>" class="input-controls">
    </div>    
</div>
<!-- Race Location -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Race Location (Town)</h3>
    </div>    
    <div class="profile-data">
        <input type="text" name="raceTown" value="<?php if(isset($row['race_id'])) {echo $row['race_town']; } ?>" class="input-controls">
    </div>    
</div>
<!-- Pool Name -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Pool Name</h3>
    </div>    
    <div class="profile-data">
        <input type="text" name="racePool" value="<?php if(isset($row['race_id'])) {echo $row['race_pool']; } ?>" class="input-controls">
    </div>    
</div>

<!-- Race Length -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Race Length (Metres)</h3>
    </div>    
    <div class="profile-data">
        <input type="number" name="raceLength" value="<?php if(isset($row['race_id'])) {echo $row['race_length']; } ?>" class="input-controls">
    </div>    
</div>
<!-- Date of Race -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Date of Race</h3>
    </div>    
    <div class="profile-data">
        <input type="date" name="dateOfRace" value="<?php if(isset($row['race_id'])) {echo $row['race_date']; } ?>" max="<?php echo date("Y-m-d"); ?>" class="input-controls">
    </div>    
</div>
