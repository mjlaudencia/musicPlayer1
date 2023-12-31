<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'MusicController::index');
$routes->post('music/createPlaylist', 'MusicController::createPlaylist');
$routes->post('music/upload', 'MusicController::uploadMusic');
$routes->post('music/getPlaylistMusic', 'MusicController::getPlaylistMusic');
$routes->post('music/addToPlaylist', 'MusicController::addToPlaylist');
$routes->get('playlist/(:num)', 'MusicController::playlists/$1');