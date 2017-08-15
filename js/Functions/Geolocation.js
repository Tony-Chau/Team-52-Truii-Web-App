class Geolocation{
  constructor(latitude_name, longititude_name){
    this.latitude_name = document.getElementById(latitude_name);
    this.longititude_name =  document.getElementById(longititude_name);
  }
  getLocation(){
    if (navigator.Geolocation){
      navigator.geolocation.getCurrentPosition(showPosition);
    }else{
      alert("Gelocation is not supported by this browser");
    }
  }
  showPosition(position){
    this.latitude_name.innerHTML = position.coords.latitude_name;
    this.longititude_name.innerHTML = position.coords.longititude_name;
  }
}
//To call the Geloction function, type: var geo = new Geolocation("lat_name", "lon_name");
//For function: geo.getLocation();
