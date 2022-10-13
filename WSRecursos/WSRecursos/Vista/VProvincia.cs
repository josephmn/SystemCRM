using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VProvincia : BDconexion
    {
        public List<EProvincia> Listar_Provincia(Int32 departamento)
        {
            List<EProvincia> lCProvincia = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CProvincia oVProvincia = new CProvincia();
                    lCProvincia = oVProvincia.Listar_Provincia(con, departamento);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCProvincia);
        }
    }
}