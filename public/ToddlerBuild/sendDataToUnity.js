function sendLocalStorageToUnity() {
    // Retrieve data from local storage
    const data = localStorage.getItem('app-key');
    
    // Check if Unity is loaded and ready
    if (typeof UnityLoader !== 'undefined') {
        // Call a Unity method from JavaScript
        unityInstance.SendMessage('ManagerReadJson', 'ReceiveData', data);
    }
}