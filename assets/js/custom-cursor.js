document.addEventListener('DOMContentLoaded', function() {
    // Create cursor elements
    const cursor = document.createElement('div');
    cursor.className = 'custom-cursor';
    document.body.appendChild(cursor);

    const follower = document.createElement('div');
    follower.className = 'custom-cursor-follower';
    document.body.appendChild(follower);

    const icon = document.createElement('div');
    icon.className = 'cursor-icon';
    document.body.appendChild(icon);

    // Cursor movement
    let posX = 0,
        posY = 0,
        mouseX = 0,
        mouseY = 0;

    TweenMax.to({}, 0.016, {
        repeat: -1,
        onRepeat: function() {
            posX += (mouseX - posX) / 9;
            posY += (mouseY - posY) / 9;

            TweenMax.set(follower, {
                css: {
                    left: posX - 20,
                    top: posY - 20
                }
            });

            TweenMax.set(cursor, {
                css: {
                    left: mouseX,
                    top: mouseY
                }
            });

            TweenMax.set(icon, {
                css: {
                    left: mouseX,
                    top: mouseY
                }
            });
        }
    });

    document.addEventListener('mousemove', function(e) {
        mouseX = e.clientX;
        mouseY = e.clientY;
    });

    // Cursor states
    const links = document.querySelectorAll('a, button, .btn, [role="button"]');
    const textElements = document.querySelectorAll('p, h1, h2, h3, h4, h5, h6, span, li');

    links.forEach(link => {
        link.addEventListener('mouseenter', function() {
            cursor.classList.add('cursor-link');
            follower.classList.add('cursor-link-follower');
            icon.innerHTML = '<i class="fas fa-hand-pointer"></i>';
            icon.classList.add('visible');
        });

        link.addEventListener('mouseleave', function() {
            cursor.classList.remove('cursor-link');
            follower.classList.remove('cursor-link-follower');
            icon.classList.remove('visible');
        });
    });

    textElements.forEach(text => {
        text.addEventListener('mouseenter', function() {
            cursor.classList.add('cursor-text');
            follower.classList.add('cursor-text-follower');
            icon.innerHTML = '<i class="fas fa-i-cursor"></i>';
            icon.classList.add('visible');
        });

        text.addEventListener('mouseleave', function() {
            cursor.classList.remove('cursor-text');
            follower.classList.remove('cursor-text-follower');
            icon.classList.remove('visible');
        });
    });

    // Hide cursor when leaving window
    document.addEventListener('mouseout', function(e) {
        if (e.relatedTarget === null) {
            cursor.style.opacity = '0';
            follower.style.opacity = '0';
            icon.style.opacity = '0';
        }
    });

    document.addEventListener('mouseover', function() {
        cursor.style.opacity = '1';
        follower.style.opacity = '1';
    });
}); 