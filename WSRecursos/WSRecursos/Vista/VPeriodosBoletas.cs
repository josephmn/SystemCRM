using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VPeriodosBoletas : BDconexion
    {
        public List<EPeriodosBoletas> PeriodosBoletas()
        {
            List<EPeriodosBoletas> lCPeriodosBoletas = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CPeriodosBoletas oVPeriodosBoletas = new CPeriodosBoletas();
                    lCPeriodosBoletas = oVPeriodosBoletas.PeriodosBoletas(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCPeriodosBoletas);
        }
    }
}