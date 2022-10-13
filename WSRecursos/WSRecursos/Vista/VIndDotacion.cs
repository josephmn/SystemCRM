using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndDotacion : BDconexion
    {
        public List<EIndDotacion> Listar_IndDotacion()
        {
            List<EIndDotacion> lCIndDotacion = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndDotacion oVIndDotacion = new CIndDotacion();
                    lCIndDotacion = oVIndDotacion.Listar_IndDotacion(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndDotacion);
        }
    }
}