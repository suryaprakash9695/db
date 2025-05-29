$( document ).ready(function() {
	$( "#load_more" ).click(function() {
		$(this).hide();
	$( "#last" ).slideDown("slow");
	});
});

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
	const menuButton = document.createElement('button');
	menuButton.className = 'mobile-menu-button';
	menuButton.innerHTML = '☰';
	document.querySelector('#header').prepend(menuButton);

	menuButton.addEventListener('click', function() {
		const nav = document.querySelector('#navigation');
		nav.classList.toggle('show');
	});

	// Close menu when clicking outside
	document.addEventListener('click', function(event) {
		const nav = document.querySelector('#navigation');
		const menuButton = document.querySelector('.mobile-menu-button');
		if (!nav.contains(event.target) && !menuButton.contains(event.target)) {
			nav.classList.remove('show');
		}
	});

	// Smooth scroll for anchor links
	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
		anchor.addEventListener('click', function(e) {
			e.preventDefault();
			const target = document.querySelector(this.getAttribute('href'));
			if (target) {
				target.scrollIntoView({
					behavior: 'smooth'
				});
			}
		});
	});

	// Add active class to current navigation item
	const currentPage = window.location.pathname.split('/').pop();
	document.querySelectorAll('#navigation a').forEach(link => {
		if (link.getAttribute('href') === currentPage) {
			link.parentElement.classList.add('current');
		}
	});
});
