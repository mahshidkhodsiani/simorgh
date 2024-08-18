

document.getElementById('editableArea').addEventListener('keydown', function(event) {
    // Check if Enter key is pressed
    if (event.key === 'Enter') {
        // Prevent default behavior (inserting a new line)
        event.preventDefault();
        // Insert a new line break
        var selection = window.getSelection();
        var range = selection.getRangeAt(0);
        var br = document.createElement('br');
        range.deleteContents();
        range.insertNode(br);
        range.setStartAfter(br);
        range.collapse(true);
        selection.removeAllRanges();
        selection.addRange(range);
    }
});



function toggleHeader(headerValue) {
    var selection = window.getSelection();
    if (selection.rangeCount > 0) {
        var range = selection.getRangeAt(0);
        var selectedText = range.toString();

        // Split the selected text into lines
        var lines = selectedText.split('\n');

        // Create a new document fragment to hold the modified content
        var fragment = document.createDocumentFragment();

        // Iterate over each line and wrap it in a header element
        lines.forEach(function(line) {
            var header = document.createElement(headerValue);
            header.textContent = line.trim(); // Trim excess white spaces
            fragment.appendChild(header);
        });

        // Replace the selected range with the modified content
        range.deleteContents();
        range.insertNode(fragment);
    }
}








// Event listener for header buttons
$('.note-toolbar .note-btn-group.note-style').on('click',
    '.note-dropdown-menu .dropdown-item[data-value^="h"]',
    function(e) {
        e.stopPropagation(); // Stop event propagation
        var headerValue = $(this).data('value');
        toggleHeader(headerValue);
    });






// Function to toggle bold for selected text
function toggleBold() {
    var selection = window.getSelection();
    if (selection.rangeCount > 0) {
        var range = selection.getRangeAt(0);
        var selectedText = range.toString();

        // Check if the selected text is already bold
        var parentNode = range.commonAncestorContainer.parentElement;
        if (parentNode && parentNode.style && parentNode.style.fontWeight === 'bold') {
            parentNode.replaceWith(document.createTextNode(selectedText));
        } else {
            var newNode = document.createElement('span');
            newNode.style.fontWeight = 'bold';
            newNode.className = 'bold'; // Adding a class to identify bold text
            range.surroundContents(newNode);
        }
    }
}

// Event listener for bold button
$('.note-btn-bold').on('click', function() {
    toggleBold();
});



function toggleUnderline() {
    var selection = window.getSelection();
    if (selection.rangeCount > 0) {
        var range = selection.getRangeAt(0);
        var selectedText = range.toString();

        // Check if the selected text is already underlined
        var parentNode = range.commonAncestorContainer.parentElement;
        if (parentNode && parentNode.style && parentNode.style.textDecoration === 'underline') {
            parentNode.replaceWith(document.createTextNode(selectedText));
        } else {
            var newNode = document.createElement('span');
            newNode.style.textDecoration = 'underline';
            newNode.className = 'underline'; // Adding a class to identify underlined text
            range.surroundContents(newNode);
        }
    }
}

// Event listener for underline button
$('.note-btn-underline').on('click', function() {
    toggleUnderline();
});


// Function to remove all styles from selected text except underline
function removeFontStyle() {
    var selection = window.getSelection();
    if (selection.rangeCount > 0) {
        var range = selection.getRangeAt(0);

        // Remove bold, italic, and text color styles
        document.execCommand('bold', false, null);
        document.execCommand('italic', false, null);
        document.execCommand('foreColor', false, 'black');

        // Get the parent element of the selected text
        var parentElement = range.commonAncestorContainer.parentElement;

        // Remove inline styles from the parent element and its descendants
        if (parentElement) {
            parentElement.removeAttribute('style');
            parentElement.querySelectorAll('*').forEach(function(element) {
                element.removeAttribute('style');
            });
        }
    }
}



// Event listener for remove font style button
$('.note-icon-eraser').on('click', function() {
    removeFontStyle();
});






// Function to toggle font family dropdown menu
function toggleFontFamilyDropdown() {
    $('.dropdown-fontname').toggleClass('show');
}

// Event listener to toggle font family dropdown menu when font family button is clicked
$('.note-btn-group.note-fontname').on('click', '.dropdown-toggle', function(e) {
    e.stopPropagation(); // Stop event propagation
    toggleFontFamilyDropdown();
});

// Event listener to apply font family to selected text when a font family is selected from the dropdown menu
$('.note-dropdown-menu.dropdown-fontname').on('click', '.dropdown-item', function(e) {
    e.preventDefault();
    var fontFamily = $(this).data('value');
    document.execCommand('fontName', false, fontFamily);
});

// Close font family dropdown menu when clicked outside
$(document).on('click', function(e) {
    if (!$(e.target).closest('.note-fontname').length) {
        $('.dropdown-fontname').removeClass('show');
    }
});

// Function to close font family dropdown menu on page load
function closeFontFamilyDropdownOnLoad() {
    $('.dropdown-fontname').removeClass('show');
}

// Event listener for when the page is loaded
$(document).ready(function() {
    closeFontFamilyDropdownOnLoad();
});










// Function to handle text color change
function changeTextColor(color) {
    document.execCommand('foreColor', false, color);
}

// Function to handle background color change
function changeBgColor(color) {
    var selection = window.getSelection();
    if (selection.rangeCount > 0) {
        var range = selection.getRangeAt(0);
        var selectedText = range.cloneContents();
        var span = document.createElement('span');
        span.style.backgroundColor = color;
        span.appendChild(selectedText);
        range.deleteContents();
        range.insertNode(span);
    }
}





function getAlignment() {
    var alignLeftButton = document.getElementById("alignLeft");
    var alignCenterButton = document.getElementById("alignCenter");
    var alignRightButton = document.getElementById("alignRight");
    var alignJustifyButton = document.getElementById("alignJustify");

    alignLeftButton.addEventListener('click', function() {
        alignText('left');
    });

    alignCenterButton.addEventListener('click', function() {
        alignText('center');
    });

    alignRightButton.addEventListener('click', function() {
        alignText('right');
    });

    alignJustifyButton.addEventListener('click', function() {
        alignText('justify');
    });

    function alignText(alignment) {
        var selectedText = window.getSelection().toString();

        // Example of how you might apply the alignment to the selected text
        var alignedText = document.createElement('div');
        alignedText.style.textAlign = alignment;
        alignedText.textContent = selectedText;

        // Replace the selected text with the aligned text
        var range = window.getSelection().getRangeAt(0);
        range.deleteContents();
        range.insertNode(alignedText);
    }
}

getAlignment(); // Call the function to initialize event listeners





// Function to handle text color change
function changeTextColor(color) {
    document.execCommand('foreColor', false, color);
}

// Function to handle background color change
function changeBgColor(color) {
    var selection = window.getSelection();
    if (selection.rangeCount > 0) {
        var range = selection.getRangeAt(0);
        var selectedText = range.cloneContents();
        var span = document.createElement('span');
        span.style.backgroundColor = color;
        span.appendChild(selectedText);
        range.deleteContents();
        range.insertNode(span);
    }
}





// Function to handle adding a link
function addLink() {
    var url = prompt("Enter the URL:");
    if (url) {
        document.execCommand('createLink', false, url);
        attachLinkEventListeners(); // Attach event listener to the new links
    }
}

// Function to handle adding a picture
function addPicture() {
    var url = prompt("Enter the URL of the image:");
    if (url) {
        var img = document.createElement('img');
        img.src = url;
        document.execCommand('insertHTML', false, img.outerHTML);
        attachImageEventListeners(); // Attach event listener to the new images
    }
}

// Attach event listeners to the buttons
document.getElementById("linkButton").addEventListener("click", addLink);
document.getElementById("pictureButton").addEventListener("click", addPicture);

// Function to attach event listeners to links
function attachLinkEventListeners() {
    var links = document.querySelectorAll('a'); // Get all the links
    links.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default action (following the link)
            window.open(link.href, '_blank'); // Open the link in a new tab
        });
    });
}

// Function to attach event listeners to images
function attachImageEventListeners() {
    var images = document.querySelectorAll('img'); // Get all the images
    images.forEach(function(img) {
        img.addEventListener('click', function(event) {
            // Handle image click event if needed
            // For example, you can open the image in a modal
            console.log('Image clicked:', img.src);
        });
    });
}

// Attach event listeners to existing links and images
attachLinkEventListeners();
attachImageEventListeners();











function saveContent() {
    var editorContent = $("#editableArea").html();

    alert(editorContent);

    // Send the content to a PHP script using AJAX
    $.ajax({
        url: "save_content.php",
        type: "POST",
        data: {
            content: editorContent
        },
        success: function(response) {
            // Response from the server (if needed)
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
        }
    });
}
