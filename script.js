// Function to check if an element is in the viewport
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Function to handle scrolling and trigger animation
function handleScrollAnimation() {
    const slideInElements = document.querySelectorAll('.slide-in');

    slideInElements.forEach((element) => {
        if (isInViewport(element)) {
            element.classList.add('active');
        }
    });
}

// Event listener for scroll event
window.addEventListener('scroll', handleScrollAnimation);

// Initial check to trigger animation for elements in view on page load
document.addEventListener('DOMContentLoaded', handleScrollAnimation);
