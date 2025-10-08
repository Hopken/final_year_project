$(document).ready(function()
{
	console.log("ready!");
	jquery.validator.setdefaults({
		debug:true,
		success:"valid"
	});
	//setrules
	$(document).ready(function()
	{
		$("#form").validate(
		{
			rules:{
				name:{
					required:true
			