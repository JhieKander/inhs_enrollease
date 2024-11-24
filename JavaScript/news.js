const newsItems = document.querySelectorAll('.news-item');
const newsItemsContainer = document.querySelector('.news-items');
const modal = document.getElementById('newsModal');
const modalImage = document.querySelector('.modal-img');
const modalTitle = document.querySelector('.modal-title');
const modalDate = document.querySelector('.modal-date');
const modalDescription = document.querySelector('.modal-description');
const closeModal = document.querySelector('.close-modal');

let curIndex = 0;
const itemWidth = newsItems[0].clientWidth + 10; // including margin

// Function to move the carousel
function moveCarousel(index) {
    const totalItems = newsItems.length;
    const maxScroll = (totalItems - 1) * itemWidth;
    const currentPosition = index * itemWidth;

    // Prevent the carousel from going beyond available items
    if (currentPosition <= maxScroll && currentPosition >= 0) {
        newsItemsContainer.style.transform = `translateX(-${currentPosition}px)`;
    }
}

// Event listeners for next/prev buttons
document.querySelector('.next-button').addEventListener('click', () => {
    curIndex = (curIndex + 1) % newsItems.length;
    moveCarousel(curIndex);
});

document.querySelector('.prev-button').addEventListener('click', () => {
    curIndex = (curIndex - 1 + newsItems.length) % newsItems.length;
    moveCarousel(curIndex);
});

// Show modal when a news item is clicked
newsItems.forEach((item) => {
    item.addEventListener('click', () => {
        const title = item.getAttribute('data-title');
        const date = item.getAttribute('data-date');
        const description = item.getAttribute('data-description');
        const imageSrc = item.getAttribute('data-image');

        modalTitle.textContent = title;
        modalDate.textContent = date;
        modalDescription.textContent = description;
        modalImage.src = imageSrc;

        modal.style.display = 'flex';
    });
});

// Close modal
closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Close modal when clicking outside content
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});
