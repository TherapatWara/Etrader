FROM python:3.9.13
WORKDIR /mt4
COPY . /mt4

RUN apt-get update && apt-get install -y libzmq3-dev
RUN pip install --upgrade pip
RUN pip install pyzmq
RUN pip install mysql-connector-python
RUN pip install numpy 
RUN pip install requests
RUN pip install tensorflow==2.15
RUN pip install pandas
RUN pip install scikit-learn

CMD ["python", "api.py", "EURUSD_v1_M15_5input.py"]

#CMD ["python","EURUSD_v1_M30_3input.py"]
#CMD ["python","usdcadM30.py"]
#CMD ["python","XAUUSD_v1_M30_5input.py"]
