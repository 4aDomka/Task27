<?php
class View
{
	function generate($content_view, $template_view, $authorised = null, $data = null, $image = null, $token = null, $roles = null, $VKparams = null)
	{
		include 'views/' . $template_view;
	}
}
