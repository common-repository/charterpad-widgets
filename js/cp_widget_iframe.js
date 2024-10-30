if (typeof window.cpwidgetResizeIFrameToFitContent !== 'function') {
    function cpwidgetResizeIFrameToFitContent(iframe) {
        if (iframe.contentWindow.document.body.getAttribute('listeners') == null) {
            iframe.contentWindow.document.body.addEventListener('DOMSubtreeModified', function(){
                iframe.width = iframe.contentWindow.document.body.scrollWidth;
                iframe.height = iframe.contentWindow.document.body.scrollHeight;
            }, false);
        } else {
            iframe.width = iframe.contentWindow.document.body.scrollWidth;
            iframe.height = iframe.contentWindow.document.body.scrollHeight;
        }
    }
}