<div id="banner-user" style="background: url('<?= $user->banner ?>'); background-size:cover; background-position: center;">
    <form id='formbanner'  method="post" enctype="multipart/form-data" action="/banner/cree">
        <input type="file" id="files-banner" name="upload-banner" class="hidden"/>
        <label for="files-banner" id="btn-add-banner" >Ajouter une bannière</label>
    </form>
</div>

<div id="profil-photo-name">
    <div id="profil-user" style="background-image: url('<?= $user->avatar ?>'); background-size:cover; background-position: center;">
        <div id="hover-profil-user">
            <form id='formavatar'  method="post" enctype="multipart/form-data" action="/avatar/cree">
            <input type="file" id="files-photo" name="upload-photo-profil" class="hidden" />
            <label for="files-photo" id="btn-add-photo-profil" >+</label>
            </form>
            </div>
    </div>
    
    <div id="profil-name-username">
        <span id="profil-name"><?= $user->realname ?></span><span> - </span><span id="profil-username"><?= $user->username ?></span>
    </div>
</div>

<div style="clear:both;"></div>

<div id="onglets-utilisateur">
        <div id="informations-utilisateur">
            <p>Informations</p>
        </div>
        <div id="playlists-utilisateur">
            <p>Playlists</p>
        </div>
        <div id="titres-utilisateur">
            <p>Titres</p>
        </div>
        <div id="albums-utilisateur">
            <p>Albums</p>
        </div>
    </div>

<script type="text/javascript">


</script>