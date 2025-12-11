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

  // Store chart data from the server
  let stressHistory = [];

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

  /* read username and userId from URL query*/
  const urlParams = new URLSearchParams(window.location.search);
  const username = urlParams.get('username');

  const userNameElement = document.getElementById('userName');
  if(username && userNameElement){
    userNameElement.textContent = username;
  }

  if(username){
    document.getElementById('userName').textContent = username;
    if(userNameElement){
      userNameElement.textContent = username;
    }
  }

  //profile button: pass userId to profile page
  const profileBtn = document.getElementById('profileBtn');
  if(profileBtn) {
    profileBtn.addEventListener('click', function(event) {
      event.preventDefault();

      if(username){
        window.location.href = `profilepage.html?username=${encodeURIComponent(username)}`
      } else {
        alert('Username not found.');
      }
  });
}


  

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
  if(emotionForm){
    emotionForm.addEventListener('submit', async function (event) {
      event.preventDefault();

      const stressLevel = stressRange ? stressRange.value : null;
      
      try {
        const response = await fetch('homepage.php?action=save_stress', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ 
            stress_level: stressLevel 
          })
        });
        

        const result = await response.json();
        
        console.log('Save response:', result);

        if(result.status === "ok"){
          alert('Emotion logged successfully');
          closeModal();
          emotionForm.reset();

          //reset stress level display
          if(stressRange && stressValueDisplay){
            stressRange.value = 5;
            stressValueDisplay.textContent = '5';
          }

          location.reload();

        } else {
          alert('Failed to save stress level. Please try again.');
        }
      } catch (error) {
        console.error('Error saving stress level:', error);
        alert('Please try again.');
      }
    });
  }



  /*Chart.js*/
function renderStressChart(){
    const canvas = document.getElementById('stressChart');
    if (!canvas) {
      return;
    }
    const ctx = canvas.getContext('2d');

  if(!Array.isArray(stressHistory) || stressHistory.length === 0){
    console.log('No stress history data to render chart.');
    return;
  }

  const labels = stressHistory.map(row => row.recorded_at);
  const dataValues = stressHistory.map(row => Number(row.stress_level));

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Stress level',
        data: dataValues,
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
}

  fetch('homepage.php?action=get_stress_history')
    .then(response => response.json())
    .then(data => {
      console.log('Chart date:', data);
      
      //if no data history, show message to log a stress level
      if((!Array.isArray(data) || data.length === 0)){
        const container = document.querySelector('.chart-container');
        if(container){
          container.innerHTML = '<p>No stress history yet, please log your first entry.</p>';
        }
        return;
      }
      
      //store fetched data and render chart
      stressHistory = data;
      renderStressChart();
    })
    
    .catch(error => {
      console.error('Error fetching stress history:', error);
      alert('Error loading stress history chart data.');
    });

});
