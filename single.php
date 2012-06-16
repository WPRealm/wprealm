<?php

//Remove post info above content
remove_action( 'genesis_before_post_content','genesis_post_info' );

genesis();