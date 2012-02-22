<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<h2>Welcome to I Love Smile maintenance mode</h2>

<p><span style="color: red">Caution!!!</span> any operations here could do harm to your system. </p>

<p>Please follow the instructions strictly by the expert.</p>
<script>
function OperationOnChange(v){
    var operation;
    var serviceName;
    for (var i=0; i<v.children.length; i++){
        if (v.children[i].selected){
            operation = v.children[i].value;
            break;
        }
    }
    serviceName = $("#service_name").val();
//    alert(operation)
//    alert(serviceName)
    if (!operation){
        alert('select an operation please')
        return;
    }
    
    if (!serviceName){
        alert('type a service name please')
        return;
    }
    
    var baseFormAction = $("#manage_windows_service_form").attr("action");
    var completedFormAction = baseFormAction + '/' + operation + '/' + serviceName;
    //alert(completedFormAction);
    $("#manage_windows_service_form").attr("action", completedFormAction)
    //alert($("#manage_windows_service_form").attr("action"));
}
$(function(){
    //OperationOnChange($("#service_operation")[0]);
})
</script>
<form onsubmit="OperationOnChange($('#service_operation')[0])" id="manage_windows_service_form" method="post" action="<?= url::site("maintenance")?>">
<table>
    <tr>
        <td>Operation:</td>
        <td><select id="service_operation">
                <option value="">--Select Operation--</option>
                <option value="Status">Check Status</option>
                <option value="StopOne">Stop Service</option>
                <option value="StartOne">Start Service</option>
                <option value="RestartOne">Restart Service</option>
            </select> 
        <td>
            Windows Service:
        </td>
        
        </td>
        <td><input id="service_name" type="text"></input></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><input type="submit"/></td>
    </tr>
</table>
</form>