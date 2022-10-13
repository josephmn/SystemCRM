using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VCuenta : BDconexion
    {
        public List<ECuenta> Listar_Cuenta()
        {
            List<ECuenta> lCCuenta = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CCuenta oVCuenta = new CCuenta();
                    lCCuenta = oVCuenta.Listar_Cuenta(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCCuenta);
        }
    }
}