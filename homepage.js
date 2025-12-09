document.addEventListener("DOMContentLoaded", function () {

  const menuButton = document.getElementById('menuButton');
  const navBar = document.getElementById('navBar');

  const openModalBtn = document.getElementById('openModalBtn');
  const modalOverlay = document.getElementById('modalOverlay');
  const closeModalBtn = document.getElementById('closeModalBtn');
  const cancelBtn = document.getElementById('cancelBtn');
  const emotionForm = document.getElementById('emotionForm');

  const stressRange = document.getElementById('stressLevel');
  const stressValueDisplay = document.getElementById('stressValue');


  /*Navigation Menu*/
  menuButton.addEventListener('click', () => {
    navBar.classList.toggle('show');
  });

  document.addEventListener('click', (event) => {
    const isClickInsideNav = navBar.contains(event.target);
    const isClickOnButton = menuButton.contains(event.target);

    if (!isClickInsideNav && !isClickOnButton) {
      navBar.classList.remove('show');
    }
  });


  /*Modal Functions*/
  function openModal() {
    modalOverlay.style.display = 'flex';
  }

  function closeModal() {
    modalOverlay.style.display = 'none';
  }


  /*Modal Listeners*/
  openModalBtn.addEventListener('click', openModal);
  closeModalBtn.addEventListener('click', closeModal);

  if (cancelBtn) {
    cancelBtn.addEventListener('click', closeModal);
  }

  modalOverlay.addEventListener('click', function (event) {
    if (event.target === modalOverlay) {
      closeModal();
    }
  });

  stressRange.addEventListener('input', function () {
    stressValueDisplay.textContent = this.value;
  });


  /*Form Submit*/
  emotionForm.addEventListener('submit', function (event) {
    event.preventDefault();

    const mood = document.getElementById('mood').value;
    const stressLevel = document.getElementById('stressLevel').value;
    const notes = document.getElementById('notes')?.value;

    console.log('Mood log:', {
      mood,
      stressLevel,
      notes,
      time: new Date().toISOString()
    });

    alert('Emotion logged successfully');
    closeModal();
    emotionForm.reset();
    stressRange.value = 5;
    stressValueDisplay.textContent = '5';
  });


  /*Chart.js*/
  const ctx = document.getElementById('stressChart').getContext('2d');

  const stressChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Mon', 'Tues', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
      datasets: [{
        label: 'Stress level',
        data: [2, 4, 5, 4, 8, 6, 2],
        borderWidth: 1,
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          suggestedMax: 10,
          title: {
            display: true,
            text: 'Stress level'
          }
        },
        x: {
          ticks: {
            maxRotation: 45,
            minRotation: 45
          }
        }
      }
    }
  });

});