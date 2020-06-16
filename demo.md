# Kubernetes Dashboard
```
token=$(microk8s kubectl -n kube-system get secret | grep default-token | cut -d " " -f1)
microk8s kubectl -n kube-system describe secret $token
https://192.168.217.150/#/error?namespace=default
```

# Generate Load
```
while true; do wget -q -O- http://192.168.217.151; echo ""; done
```

# Generate 2x Load
```
while true; do wget -q -O- http://192.168.217.151/load_2x.php; echo ""; done
```

# Generate 3x Load
```
while true; do wget -q -O- http://192.168.217.151/load_3x.php; echo ""; done
```