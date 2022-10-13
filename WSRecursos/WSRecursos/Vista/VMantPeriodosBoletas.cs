using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantPeriodosBoletas : BDconexion
    {
        public List<EMantenimiento> MantPeriodosBoletas(Int32 post, Int32 id, String periodo, Int32 estado, String firma, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantPeriodosBoletas oVMantPeriodosBoletas = new CMantPeriodosBoletas();
                    lCEMantenimiento = oVMantPeriodosBoletas.MantPeriodosBoletas(con, post, id, periodo, estado, firma, user);
                }
                catch (SqlException)
                {

                }
            }
            return (lCEMantenimiento);
        }
    }
}