class Geolocation{
  constructor(Button_name, longititude_name, latitude_name){
    this.Button = document.getElementById(Button_name);
    this.latitude_name = document.getElementById(latitude_name);
    this.longititude_name =  document.getElementById(longititude_name);
  }
  function getLocation(){
    if (navigator.Geolocation){
      navigator.geolocation.getCurrentPosition(showPosition);
    }else{
      alert("Gelocation is not supported by this browser");
    }
  }
  function showPosition(position){
    this.latitude_name.innerHTML = position.coords.latitude_name;
    this.longititude_name.innerHTML = position.coords.longititude_name;
  }
}
