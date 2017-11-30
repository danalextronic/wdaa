<?php

return array(

	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'wdaa',
			'username'  => 'root',
			'password'  => '',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),

		'old' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'wdaajudge',
			'username'  => 'root',
			'password'  => 'admin',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => 'tbl_',
		)
	)
);
