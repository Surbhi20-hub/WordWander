const progressBar = document.getElementById('progressBar');
const proceedButton = document.getElementById('proceedButton');
let selectedLanguage = null;

// Mapping language cards to their corresponding pages
const languagePages = {
  spanish: 'spanish-basics.html',
  chinese: 'chinese-basics.html',
  french: 'french-basics.html',
  japanese: 'japanese-basics.html',
  german: 'german-basics.html',
};

// Function to handle language card selection
function selectLanguage(card) {
  // Deselect previously selected card
  if (selectedLanguage) {
    selectedLanguage.classList.remove('selected');
  }

  // Select the current card
  card.classList.add('selected');
  selectedLanguage = card;

  // Play audio for the selected language
  const audioId = card.querySelector('audio').id;
  playAudio(audioId);

  // Show the language-specific information in the center without overlay
  const languageKey = card.dataset.language;
  const infoSection = document.getElementById('languageInfoSection');
  const image = infoSection.querySelector('img');
  const info = infoSection.querySelector('p');
  const proceed = infoSection.querySelector('button');

  image.src = `images/${languageKey}-info.png`; // Assume corresponding images are in "images" folder
  image.alt = `${languageKey} information`;

  info.textContent = `Learn basic ${languageKey} phrases and grammar.`;

  proceed.addEventListener('click', () => {
    const targetPage = languagePages[languageKey];
    if (targetPage) {
      window.location.href = targetPage;
    }
  });

  // Show the language information section
  infoSection.style.display = 'flex';

  // Ensure the Proceed button is visible
  proceedButton.style.display = 'block';  // Force visibility
  console.log('Proceed button should be visible now');
}

// Function to play audio
function playAudio(audioId) {
  const audio = document.getElementById(audioId);
  if (audio) {
    audio.currentTime = 0; // Reset to the beginning
    audio.play().catch((error) => {
      console.error("Audio playback failed:", error);
    });
  }
}

// Event listener for the proceed button
proceedButton.addEventListener('click', () => {
  if (selectedLanguage) {
    const languageKey = selectedLanguage.dataset.language; // Get language key from the card
    const targetPage = languagePages[languageKey]; // Get the target page from the mapping

    if (targetPage) {
      console.log(`Proceeding to ${targetPage}.`);
      window.location.href = targetPage; // Redirect to the corresponding page
    } else {
      console.error("No page found for the selected language.");
    }
  } else {
    console.error("No language selected.");
  }
});

// Utility function to handle localStorage for user data
function saveUserData(userData) {
  localStorage.setItem('userData', JSON.stringify(userData));
}

function getUserData() {
  return JSON.parse(localStorage.getItem('userData')) || {};
}

function clearUserData() {
  localStorage.removeItem('userData');
}

// Check if the user is logged in
const userData = getUserData();
if (userData.name) {
  // Restore user profile
  const userIcon = document.getElementById('userIcon');
  if (userData.photo) {
    userIcon.src = userData.photo; // Restore photo
  }
}

// User logout
const logoutButton = document.getElementById('logoutButton');
logoutButton.addEventListener('click', () => {
  clearUserData();
  window.location.href = 'index.php'; // Redirect to the first page
});

// Show user modal for updating profile
const userIcon = document.getElementById('userIcon');
const userModal = document.getElementById('userModal');
const closeModal = document.getElementById('closeModal');
const userForm = document.getElementById('userForm');

userIcon.addEventListener('click', () => {
  userModal.style.display = 'flex';
});

closeModal.addEventListener('click', () => {
  userModal.style.display = 'none';
});

window.addEventListener('click', (event) => {
  if (event.target === userModal) {
    userModal.style.display = 'none';
  }
});

userForm.addEventListener('submit', (event) => {
  event.preventDefault();

  const userName = document.getElementById('userName').value;
  const userPhoto = document.getElementById('userPhoto').files[0];
  const uploadStatus = document.getElementById('uploadStatus'); // Element to show the upload status

  if (userName) {
    userData.name = userName;
  }

  if (userPhoto) {
    const fileType = userPhoto.type.toLowerCase();
    if (fileType === "image/png") {
      const reader = new FileReader();
      reader.onload = (e) => {
        userData.photo = e.target.result; // Save photo as base64 string
        userIcon.src = e.target.result; // Update user icon

        // Update the upload status to show success message
        uploadStatus.textContent = "Image Uploaded";
        uploadStatus.style.color = "green";

        saveUserData(userData);
      };
      reader.readAsDataURL(userPhoto);
    } else {
      // Update the upload status to show error message
      uploadStatus.textContent = "Only PNG files are allowed!";
      uploadStatus.style.color = "red";
    }
  } else {
    uploadStatus.textContent = ""; // Clear the status if no file is selected
    saveUserData(userData); // Save data without photo
  }
});

// Check if the button is correctly visible when the language info is shown
const infoSection = document.getElementById('languageInfoSection');
const languageCards = document.querySelectorAll('.languageCard'); // Assuming you have these cards with the 'languageCard' class

languageCards.forEach(card => {
  card.addEventListener('click', () => {
    selectLanguage(card);
  });
});

// Debugging if button visibility isn't working
setTimeout(() => {
  if (proceedButton.style.display === 'none') {
    proceedButton.style.display = 'block'; // Force visibility if it's still hidden
    console.log('Force proceed button to be visible');
  }
}, 200);
