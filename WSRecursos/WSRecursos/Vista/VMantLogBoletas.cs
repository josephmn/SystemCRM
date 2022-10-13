using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantLogBoletas : BDconexion
    {
        public List<EMantenimiento> MantLogBoletas(String dni, String nroboleta, String ip)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantLogBoletas oVMantLogBoletas = new CMantLogBoletas();
                    lCEMantenimiento = oVMantLogBoletas.MantLogBoletas(con, dni, nroboleta, ip);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}