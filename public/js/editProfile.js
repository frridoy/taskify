function editProfile() {
  let editedProfile = document.querySelectorAll(".profile-edited");

  for (let profile of editedProfile) {
    if (profile.disabled) {
      profile.disabled = false;
      profile.classList.add("bg-white");
    }
  }
  document.getElementById("editBtnShow").classList.remove("d-none");
  document.querySelector(".profile-camera-icon").classList.remove("d-none");
}
