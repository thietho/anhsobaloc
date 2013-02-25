function Order()
{
	this.updateStatus = function(orderid,status)
	{
		$.ajax({
			  url: "?route=addon/order/updatestatus&orderid="+orderid+"&status="+status,
			  cache: false,
			  success: function(html){
				
			  }
			});
	}
	
	this.getOrder = function()
	{
		$.getJSON("?route=addon/order/getOrders&col=status&val=new&operator=", 
				function(data) 
				{
					$("#orderwarring").html(" ("+data.orders.length+" new)");
					//setTimeout('order.getOrder()',5000);
				});	
	}	
}

var order = new Order();

$(document).ready(function(){
	order.getOrder();
});