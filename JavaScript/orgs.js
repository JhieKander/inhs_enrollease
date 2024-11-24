// Data for each program
const programs = [
    {
        name: "SSLG",
        title: "Supreme Secondary Learner Government",
        description: "The official student governing body of Imus National High School.",
        img: "images/Untitled-removebg-preview.png"
    },
    {
        name: "Interact Club",
        title: "Interact Club of Imus National High School",
        description: "A school organization focusing on fueling a lifetime of service for young people ages 12-18.",
        img: "images/309353542_204132041956941_5928896023165797684_n.jpg"
    },
    {
        name: "Panitik Imuseño",
        title: "Panitik Imuseño",
        description: "The official student publication organization of Imus National High School.",
        img: "images/299474299_450958437044485_2167183741513976857_n.jpg"
    },
    {
        name: "YES-O",
        title: "Youth for Environment in Schools - Organization (YES-O)",
        description: "The student organization of Imus National High School that focuses on protecting the environment.",
        img: "images/315443594_1819582191709311_2558313584327624381_n.jpg"
    },
    {
        name: "Junior Medics",
        title: "Junior Medics",
        description: "The official student medics organization of Imus National High School.",
        img: "images/302246206_424176806478611_761231511145420417_n.jpg"
    },
    {
        name: "Junior Polaris",
        title: "Junior Polaris",
        description: "The Disaster Risk Reduction Management Organization of Imus National High School.",
        img: "images/367463715_122100082190010791_7347197301827311395_n.jpg"
    },
    {
        name: "Teatro Imuseño",
        title: "Teatro Imuseño",
        description: "The Performing Arts group of Imus National High School.",
        img: "images/382967452_769694645167280_4644511243250551005_n.jpg"
    }
];

let currentIndex = 0;

// Function to update the displayed program with a transition
function updateProgram(index) {
    const contentDiv = document.querySelector(".content");
    const titleElement = document.querySelector(".content h3");
    const descriptionElement = document.querySelector(".content p");
    const imgElement = document.querySelector(".content img");
    const tags = document.querySelectorAll(".tags span");

    // Fade-out the content
    contentDiv.classList.add("fade-out");

    // After the fade-out transition, update the content and fade-in
    setTimeout(() => {
        const program = programs[index];
        
        // Update the content
        titleElement.textContent = program.title;
        descriptionElement.textContent = program.description;
        imgElement.src = program.img;

        // Update active tag
        tags.forEach(tag => tag.classList.remove("active"));
        tags[index].classList.add("active");

        // Fade-in the updated content
        contentDiv.classList.remove("fade-out");
    }, 300); // This should match the transition duration
}

// Event listener for the next button
document.querySelector(".next-button").addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % programs.length; // Cycle through the programs
    updateProgram(currentIndex);
});

// Optional: Add click event to each tag to select directly
document.querySelectorAll(".tags span").forEach((tag, index) => {
    tag.addEventListener("click", () => {
        currentIndex = index;
        updateProgram(currentIndex);
    });
});

setInterval(() => {
    currentIndex = (currentIndex + 1) % programs.length;
    updateProgram(currentIndex);
}, 5000);

const newsItems = document.querySelectorAll('.news-item');
const newsItemsContainer = document.querySelector('.news-items');
const modal = document.getElementById('newsModal');
const modalImage = document.querySelector('.modal-img');
const modalTitle = document.querySelector('.modal-title');
const modalDate = document.querySelector('.modal-date');
const modalDescription = document.querySelector('.modal-description');
const closeModal = document.querySelector('.close-modal');

let curIndex = 0;
const itemWidth = newsItems[0].clientWidth + 10; // includes margin
const totalItems = newsItems.length;

// Function to move the news carousel
function moveNewsCarousel(index) {
    const maxScroll = (totalItems - 1) * itemWidth;
    const currentPosition = index * itemWidth;

    if (currentPosition <= maxScroll && currentPosition >= 0) {
        newsItemsContainer.style.transform = `translateX(-${currentPosition}px)`;
    }
}

// Function to format the date
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' };
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', options);
}

// Event listeners for next/prev buttons
document.querySelector('.nexti-button').addEventListener('click', () => {
    curIndex = Math.min(curIndex + 1, totalItems - 1);
    moveNewsCarousel(curIndex);
});

document.querySelector('.previ-button').addEventListener('click', () => {
    curIndex = Math.max(curIndex - 1, 0);
    moveNewsCarousel(curIndex);
});

// Show modal when a news item is clicked
newsItems.forEach((item) => {
    item.addEventListener('click', () => {
        const title = item.getAttribute('data-title');
        const date = item.getAttribute('data-date');
        const formattedDate = formatDate(date); // Format the date
        const description = item.getAttribute('data-description').replace(/\n/g, '<br>'); // Replace newlines with <br>
        const imageSrc = item.getAttribute('data-image');

        modalTitle.textContent = title;
        modalDate.textContent = formattedDate; // Use formatted date
        modalDescription.innerHTML = description; // Use innerHTML to allow <br> tags
        modalImage.src = imageSrc;

        modal.style.display = 'flex';
    });
});

// Close modal functionality
closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Close modal when clicking outside of it
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

// Auto move the news carousel every 10 seconds

setInterval(() => {
    curIndex = (curIndex + 1) % totalItems;
    moveNewsCarousel(curIndex);
}, 10000);

// Get the modal and its elements
const modal1 = document.getElementById('myModal');
const modalImage1 = document.getElementById('modalImage');
const closeModal1 = document.getElementById('closeModal');

// Get the carousel and its images
const carousel = document.querySelector('.carousel');
const carouselImages = document.querySelectorAll('.carousel-img');

// Initialize the current index
let indexCur = 0;

// Function to move the carousel
function moveCarousel(index) {
    carousel.style.transform = `translateX(-${index * carouselImages[0].clientWidth}px)`;
}

// Event listener for modal close button
closeModal1.addEventListener('click', () => {
    modal1.style.display = 'none';
});

// Event listener for modal background click
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal1.style.display = 'none';
    }
});

// Event listeners for carousel images
carouselImages.forEach((image, index) => {
    image.addEventListener('click', () => {
        modalImage1.src = image.src;
        modal1.style.display = 'block';
    });
});
// Auto move the carousel every 10 seconds
setInterval(() => {
    indexCur = (indexCur + 1) % carouselImages.length;
    moveCarousel(indexCur);
}, 5000);