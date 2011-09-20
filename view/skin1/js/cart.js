function Cart()
{
	this.add = function(mediaid)
	{
		$.get(HTTP_SERVER+"?route=addon/cart/add&mediaid="+mediaid,
			function(data){
				if(data == "true")
				{
					$("#sitebarcartlist").load(HTTP_SERVER+"?route=sitebar/cart/getList");
				}
				
			}
		);
	}
	
	this.update = function(mediaid,qty)
	{
		$.get(HTTP_SERVER+"?route=addon/cart/update&mediaid="+mediaid+"&qty="+qty,
			function(data){
				if(data == "true")
				{
					$("#sitebarcartlist").load(HTTP_SERVER+"?route=sitebar/cart/getList");
					$("#addoncartlist").load(HTTP_SERVER+"?route=addon/cart/getList");
				}
				
			}
		);
	}
	
	this.remove = function(mediaid)
	{
		$.get(HTTP_SERVER+"?route=addon/cart/remove&mediaid="+mediaid,
			function(data){
				if(data == "true")
				{
					$("#sitebarcartlist").load(HTTP_SERVER+"?route=sitebar/cart/getList");
					$("#addoncartlist").load(HTTP_SERVER+"?route=addon/cart/getList");
				}
				
			}
		);
	}
}

var cart = new Cart();