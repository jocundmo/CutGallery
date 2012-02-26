function TruncateText(text, maxWidth) {
    if (text.length >= maxWidth)
        text = (text.substring(0, maxWidth) + "...");

    return text;
}

function isNotMax(oTextArea){
//       if(event.keyCode==13) {
//           if (oTextArea.maxEnter == undefined) {
//               oTextArea.maxEnter = 1;
//           }
//           else {
//               oTextArea.maxEnter++;
//           }
//            if (oTextArea.maxEnter >= 3)
//           return false;
//       }
 return oTextArea.value.length != oTextArea.getAttribute("maxlength"); }