# Kubernetes Dashboard
```
token=$(microk8s kubectl -n kube-system get secret | grep default-token | cut -d " " -f1)
microk8s kubectl -n kube-system describe secret $token
https://192.168.217.150/#/error?namespace=default

eyJhbGciOiJSUzI1NiIsImtpZCI6IlBlcHc5WWJsVjJrVER3SE80OUlJWUw1c0trWTcwaGVBX3RSa0RCQm9ndWMifQ.eyJpc3MiOiJrdWJlcm5ldGVzL3NlcnZpY2VhY2NvdW50Iiwia3ViZXJuZXRlcy5pby9zZXJ2aWNlYWNjb3VudC9uYW1lc3BhY2UiOiJrdWJlLXN5c3RlbSIsImt1YmVybmV0ZXMuaW8vc2VydmljZWFjY291bnQvc2VjcmV0Lm5hbWUiOiJkZWZhdWx0LXRva2VuLWpqbjV4Iiwia3ViZXJuZXRlcy5pby9zZXJ2aWNlYWNjb3VudC9zZXJ2aWNlLWFjY291bnQubmFtZSI6ImRlZmF1bHQiLCJrdWJlcm5ldGVzLmlvL3NlcnZpY2VhY2NvdW50L3NlcnZpY2UtYWNjb3VudC51aWQiOiIwMWY0OGNlNC0wMWYwLTQ5ZmItODAxNS03ZjIzNDA4NjZhZWIiLCJzdWIiOiJzeXN0ZW06c2VydmljZWFjY291bnQ6a3ViZS1zeXN0ZW06ZGVmYXVsdCJ9.mcNfO5G73Y_4ZNI1YLKHUPOA3ASjzeEdK4DcxMjRvAsedhkZOSAtuoDJx5-9TTmv5qdpOaOj18SxaMF3_w_WtHt_m64ah1IkopIE2d3GbsL-tAJK-Syd03lLwQzQDaMlrnahRdqpsQ447ah0o02p_uzHpvsbDAU2dBfaU9VYemUTF5qoFYXyheXfZMgm2y1VH-yBFwCgIFspKCFIt7fRU1_pr6NU7hdyOCKiPW5c7vlwyNEoXd8iU4Jz7fXFKnpZZBvT7CEJDh40LCtzPD0wloPLvohnOUaE6YW8sgfYMzq-gzAtLGIKDFXAVIVLQqfV2x4lvwiNzZAvfFc20A2SHw
```

# Generate Load
```
while true; do wget -q -O- http://192.168.217.202; echo ""; done
```

# Generate 2x Load
```
while true; do wget -q -O- http://192.168.217.202/load_2x.php; echo ""; done
```

# Generate 3x Load
```
while true; do wget -q -O- http://192.168.217.202/load_3x.php; echo ""; done
```