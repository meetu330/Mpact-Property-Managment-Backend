<?php foreach ($data['name'] as $key => $value) {?>
    <div class="searchbar-result searchbar-result-doctor">
        <div class="searchbar-result-profile">
            <div class="searchbar-result-profile-avatar">
                <?php
                if($value->vProfileImage != ""){
                    $image = base_url()."assets/uploads/doctor/".$value->vProfileImage;
                ?>
                <img id="img" src="<?php echo $image;?>" class="name" data-keyword="<?php echo $value->vFirstName;?>" width="34px" height="auto"/>
                <?php } else { ?>
                    <i class="pe-7s-user"></i>
                <?php }?>
            </div>
            <div class="searchbar-result-profile-details">
                <span class="name" data-keyword="<?php echo $value->vFirstName;?>">Dr <?php echo ucwords($value->vFirstName." ".$value->vLastName);?></span> 
            </div>
        </div>
    </div>
<?php }?>
<?php foreach ($data['clinic'] as $key => $value) {?>
    <div class="searchbar-result searchbar-result-clinic">
        <div class="searchbar-result-profile">
            <div class="searchbar-result-profile-avatar clinic">
                <i class="icon-hospital"></i>
            </div>
            <div class="searchbar-result-profile-details">
                <span class="clinic" data-keyword="<?php echo $value->vClinicName;?>"><?php echo $value->vClinicName;?></span>
            </div>
        </div>
    </div>
<?php }?>
<?php foreach ($data['specialization'] as $key => $value) {?>
    <div class="searchbar-result searchbar-result-spacialization">
        <div class="searchbar-result-profile">
            <div class="searchbar-result-profile-avatar spacialaiz">
                <i class="icon-user-md"></i>
            </div>
            <div class="searchbar-result-profile-details">
                <span class="specialization" data-keyword="<?php echo $value->vSpecialization;?>"><?php echo $value->vSpecialization;?></span>
            </div>
        </div>
    </div>
<?php }?>