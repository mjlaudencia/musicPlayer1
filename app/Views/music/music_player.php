<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="<?= base_url('public/script.js') ?>"></script>
    <style>
    body {
         font-family: Arial, sans-serif;
         text-align: center;
         background-color: #f785f5;
         padding: 20px;
     }

     h1 {
         color: #333;
     }

     #player-container {
         max-width: 400px;
         margin: 0 auto;
         padding: 20px;
         background-color: #ff101f;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
     }

     audio {
         width: 100%;
     }

     #playlist {
         list-style: none;
         padding: 0;
     }

     #playlist li {
         cursor: pointer;
         padding: 10px;
         background-color: #eee;
         margin: 5px 0;
         transition: background-color 0.2s ease-in-out;
     }

     #playlist li:hover {
         background-color: #ddd;
     }

     #playlist li.active {
         background-color: #007bff;
         color: #fff;
     }
    </style>
    <style>
    /* Your existing styles */

    .add-to-playlist {
        display: inline-block;
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .add-to-playlist:hover {
        background-color: #0056b3;
    }
</style>

</head>
<body>

 <!-- Example Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">My Playlist</h5>
            </div>
            <div class="modal-body">
                <ul id="playlist-list" style="list-style: none; padding: 0;"> <!-- Add inline style here -->
                    <?php if (isset($playlists) && is_array($playlists)) : ?>
                        <?php foreach ($playlists as $playlist) : ?>
                            <li>
                            <a href="<?= base_url('playlist/' . $playlist['id']) ?>" class="playlist-link" data-playlist-id="<?= $playlist['id'] ?>">
    <?= $playlist['name'] ?>
</a>

                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li>No playlists available.</li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <a href="#" data-bs-dismiss="modal">Close</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#createPlaylist">Create New</a>
            </div>
        </div>
    </div>
</div>



<!-- Modal create -->
<div class="modal fade" id="createPlaylist" tabindex="-1" role="dialog" aria-labelledby="createPlaylistLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createPlaylistLabel">Create Playlist</h5>
      </div>
      <div class="modal-body">
        <!-- Form for creating a new playlist -->
        <form action="<?= site_url('music/createPlaylist') ?>" method="post">
          <input type="text" class="form-control" name="playlist_name" placeholder="Playlist Name" required>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<form id="search-form">
    <input type="search" id="search-input" placeholder="Search for a song">
    <button type="button" id="search-button" class="btn btn-primary">Search</button>
</form>
<ul id="playlist">
    <!-- Your existing playlist items will be displayed here -->
</ul>



    <h1>Music Player</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">My Playlist</button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadMusic">Upload Music</button>

    <div class="modal fade" id="uploadMusic" tabindex="-1" aria-labelledby="uploadMusicLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadMusicLabel">Upload Music</h5>
            </div>
            <div class="modal-body">
                <!-- Form for uploading music -->
                <form action="/music/upload" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="musicFile">Choose Music File (MP3)</label>
                        <input type="file" class="form-control-file" id="musicFile" name="musicFile" accept=".mp3" required>
                    </div>
                    <div class="form-group">
                        <br>
                        <input type="text" class="form-control" id="musicName" name="musicName" placeholder="Enter the file name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="current-music-name" style= "margin-top: 20px;"></div>
    <audio id="audio" controls autoplay></audio>
    <div class="container" id="selected-playlist-container">
    <!-- Playlist tracks will be displayed here -->
</div>

    
<div class="container" id="playlist-container">
    <ul id="playlist">
    <?php foreach ($musicList as $music): ?>
        <li>
            <a href="javascript:void(0);" class="play-music" data-src="<?= base_url($music['file_path']) ?>">
                <?= $music['file_name'] ?>
            </a>
            <button type="button" class="add-to-playlist" data-music="<?= $music['id'] ?>">+</button>
        </li>
    <?php endforeach; ?>
    </ul>
</div>

          <!-- Modal select from playlist -->
    <div class="modal" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Select from playlist</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form action="/" method="post">
                <input type="hidden" id="musicID" name="musicID">
            <select name="playlist" class="form-control">
         <?php foreach ($playlists as $playlist) : ?>
            <option value="<?= $playlist['id'] ?>"><?= $playlist['name'] ?></option>
         <?php endforeach; ?>
      </select>
      <button type="submit" name="add" class="btn btn-primary">Add to Playlist</button>
   </form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>


<script>
    $(document).ready(function () {
        const playlistItems = document.querySelectorAll('.play-music');
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');
        const playlistContainer = document.getElementById('playlist');

        searchButton.addEventListener('click', function () {
            const searchTerm = searchInput.value.toLowerCase();

            playlistItems.forEach((item) => {
                const musicName = item.innerText.toLowerCase();

                if (musicName.includes(searchTerm)) {
                    item.parentElement.style.display = 'block';
                } else {
                    item.parentElement.style.display = 'none';
                }
            });
        });

        // Add a listener to reset the list when the search input is cleared
        searchInput.addEventListener('input', function () {
            if (searchInput.value === '') {
                playlistItems.forEach((item) => {
                    item.parentElement.style.display = 'block';
                });
            }
        });

        // Add a listener to reset the list when a song is chosen
        playlistItems.forEach((item) => {
            item.addEventListener('click', function () {
                playlistItems.forEach((item) => {
                    item.parentElement.style.display = 'block';
                });
            });
        });
    });
</script>


<script>
$(document).ready(function () {
    const modal = $("#myModal");

    $("form", modal).on("submit", function (e) {
        e.preventDefault();

        const musicID = $("#musicID").val();
        const playlistID = $("select[name='playlist']").val();

        // Send the selected playlist and music ID to the server
        $.ajax({
            type: "POST",
            url: "/music/addToPlaylist",
            data: {
                musicID: musicID,
                playlistID: playlistID,
            },
            success: function (response) {
                // Handle the server response as needed
                modal.modal("hide");
            },
        });
    });
});
$(document).ready(function () {
    const modal = $("#myModal");
    const musicID = $("#musicID");

    // Add click event listeners to all "Add" buttons
    $(".add-to-playlist").on("click", function () {
        const musicTrackID = $(this).data("music"); // Get the music track ID

        // Set the music track ID in the hidden input field
        musicID.val(musicTrackID);

        // Display the modal
        modal.modal("show");
    });

    // Handle form submission
    $("form", modal).on("submit", function (e) {
        e.preventDefault();
        // Handle the form submission as described in the previous answer.
    });
});
$(document).ready(function () {
   const modal = $("#myModal");

   $("form", modal).on("submit", function (e) {
      e.preventDefault();

      const musicID = $("#musicID").val();
      const playlistID = $("select[name='playlist']").val();

      // Send the selected playlist and music ID to the server
      $.ajax({
         type: "POST",
         url: "/music/addToPlaylist",
         data: {
            musicID: musicID,
            playlistID: playlistID,
         },
         success: function (response) {
            // Handle the server response as needed
            modal.modal("hide");
         },
      });
   });
});
</script>

<script>
    $(document).ready(function () {
  // Get references to the button and modal
  const modal = $("#myModal");
  const modalData = $("#modalData");
  const musicID = $("#musicID");
  // Function to open the modal with the specified data
  function openModalWithData(dataId) {
    // Set the data inside the modal content
    modalData.text("Data ID: " + dataId);
    musicID.val(dataId);
    // Display the modal
    modal.css("display", "block");
  }

  // Add click event listeners to all open modal buttons

  // When the user clicks the close button or outside the modal, close it
  modal.click(function (event) {
    if (event.target === modal[0] || $(event.target).hasClass("close")) {
      modal.css("display", "none");
    }
  });
});
</script>
<script>
   const audio = document.getElementById('audio');
const playlistItems = document.querySelectorAll('.play-music');
const currentMusicName = document.getElementById('current-music-name');

let currentTrack = 0;

function playTrack(trackIndex) {
    if (trackIndex >= 0 && trackIndex < playlistItems.length) {
        const track = playlistItems[trackIndex];
        const trackSrc = track.getAttribute('data-src');
        audio.src = trackSrc;
        audio.play();
        currentTrack = trackIndex;
        // Set the current music name
        currentMusicName.textContent = track.innerText;
    }
}

function nextTrack() {
    currentTrack = (currentTrack + 1) % playlistItems.length;
    playTrack(currentTrack);
}

function previousTrack() {
    currentTrack = (currentTrack - 1 + playlistItems.length) % playlistItems.length;
    playTrack(currentTrack);
}

playlistItems.forEach((item, index) => {
    item.addEventListener('click', () => {
        playTrack(index);
    });
});

audio.addEventListener('ended', () => {
    nextTrack();
});

playTrack(currentTrack);

</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const musicFileInput = document.getElementById("musicFile");
    const musicNameInput = document.getElementById("musicName");

    musicFileInput.addEventListener("change", function () {
      // When a file is selected, set the input field's value to the chosen file's name
      if (musicFileInput.files.length > 0) {
        musicNameInput.value = musicFileInput.files[0].name;
      }
    });
  });
  $(document).ready(function () {
    const modal = $("#myModal");
    const musicID = $("#musicID");

    // Add click event listeners to all "Add" buttons
    $(".add-to-playlist").on("click", function () {
        const musicTrackID = $(this).data("music"); // Get the music track ID

        // Set the music track ID in the hidden input field
        musicID.val(musicTrackID);

        // Display the modal
        modal.modal("show");
    });

    // Handle form submission
    $("form", modal).on("submit", function (e) {
        e.preventDefault();

        const musicID = $("#musicID").val();
        const playlistID = $("select[name='playlist']").val();

        // Send the selected playlist and music ID to the server
        $.ajax({
            type: "POST",
            url: "/music/addToPlaylist",
            data: {
                musicID: musicID,
                playlistID: playlistID,
            },
            success: function (response) {
                // Handle the server response as needed
                modal.modal("hide");
            },
        });
    });
});
</script>
<!-- <script>
$(document).ready(function () {
    // Add a click event listener to playlist links
    $('.playlist-link').on('click', function () {
        const playlistID = $(this).data('playlist-id');
        
        // Send an AJAX request to fetch playlist details
        $.ajax({
            type: 'POST',
            url: '<?= site_url('music/getPlaylist') ?>/' + playlistID,
            success: function (response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    // Update the #playlist-details container with the fetched data
                    $('#playlist-details').html(renderPlaylist(response.playlist, response.musicTracks));
                }
            },
        });
    });

    // Function to render the playlist details
    function renderPlaylist(playlist, musicTracks) {
        let html = '<h1>Playlist: ' + playlist.name + '</h1>';
        html += '<ul id="playlist">';
        musicTracks.forEach(function (track) {
            html += '<li>';
            html += '<a href="javascript:void(0);" class="play-music" data-src="' + track.file_path + '">' + track.file_name + '</a>';
            html += '<button class="add-to-playlist" data-music="' + track.id + '">+</button>';
            html += '</li>';
        });
        html += '</ul>';
        return html;
    }
});

</script> -->
</body>
</html>
