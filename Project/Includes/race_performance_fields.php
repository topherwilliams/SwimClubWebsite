
<div class="profile-group">
    <div class="profile-label">
        <h3>Race Name</h3>
    </div>    
    <div class="profile-data">
        <input disabled type="text" name="raceName" value="<?php if(isset($raceDetailsRow['race_id'])) {echo $raceDetailsRow['race_name']; } ?>" class="input-controls">
    </div>    
</div>
<!-- Race Location -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Race Location (Town)</h3>
    </div>    
    <div class="profile-data">
        <input disabled type="text" name="raceTown" value="<?php if(isset($raceDetailsRow['race_id'])) {echo $raceDetailsRow['race_town']; } ?>" class="input-controls">
    </div>    
</div>
<!-- Pool Name -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Pool Name</h3>
    </div>    
    <div class="profile-data">
        <input disabled type="text" name="racePool" value="<?php if(isset($raceDetailsRow['race_id'])) {echo $raceDetailsRow['race_pool']; } ?>" class="input-controls">
    </div>    
</div>

<!-- Race Length -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Race Length (Metres)</h3>
    </div>    
    <div class="profile-data">
        <input disabled type="number" name="raceLength" value="<?php if(isset($raceDetailsRow['race_id'])) {echo $raceDetailsRow['race_length']; } ?>" class="input-controls">
    </div>    
</div>
<!-- Date of Race -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Date of Race</h3>
    </div>    
    <div class="profile-data">
        <input disabled type="date" name="dateOfRace" value="<?php if(isset($raceDetailsRow['race_id'])) {echo $raceDetailsRow['race_date']; } ?>" max="<?php echo date("Y-m-d"); ?>" class="input-controls">
    </div>    
</div>

<!-- Race Performance -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Race Performance (Seconds)</h3>
    </div>    
    <div class="profile-data">
        <input type="number" name="racePerformance" value="<?php if(isset($raceperformancerow['race_id'])) {echo $raceperformancerow['performance']; } ?>" class="input-controls">
    </div>    
</div>

<?php
if (isset($raceperformancerow['race_id'])) {
    echo "
        <input hidden type='text' name='editraceperformanceID' value='{$raceperformancerow['race_performance_id']}'>
    ";
}

?>