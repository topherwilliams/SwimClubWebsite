<div id="search-fields">
    <div>
        <h3>Search Filters:</h3>
    </div>
    <div id="search-options">
        <div class="search-option">
            <input name="race_town" class="search-input" style="width:105%" type="text" placeholder="Location (Town or Pool)...">
        </div>
        <div class="search-option">
            <input name="race_length" class="search-input" style="width:105%" type="number" placeholder="Distance (Metres)...">
        </div>
        <div class="search-option" style="white-space: nowrap;">
            <label for="race_dateStart" style="font-size: 13px; margin-right:3px;">Race Date Range: </label>
            <input name="race_dateStart" style="width:30%" class="search-input" max="<?php echo date("Y-m-d"); ?>" type="date">
            <label for="race_dateEnd" style="font-size: 13px; margin-left:3px; margin-right:3px;"> - </label>
            <input name="race_dateEnd" style="width:30%" class="search-input" max="<?php echo date("Y-m-d"); ?>" type="date">
        </div>
        <button class="colourButton colourButton-Small" name="searchRaces">Search</button>
    </div>
</div>