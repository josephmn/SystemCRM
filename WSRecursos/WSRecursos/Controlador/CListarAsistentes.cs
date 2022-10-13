using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CListarAsistentes
    {
        public List<EListarAsistentes> Listar_ListarAsistentes(SqlConnection con, String dni)
        {
            List<EListarAsistentes> lEListarAsistentes = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_ASISTENTES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarAsistentes = new List<EListarAsistentes>();

                EListarAsistentes obEListarAsistentes = null;
                while (drd.Read())
                {
                    obEListarAsistentes = new EListarAsistentes();
                    obEListarAsistentes.v_dni_asistente = drd["v_dni_asistente"].ToString();
                    obEListarAsistentes.v_nombre = drd["v_nombre"].ToString();
                    obEListarAsistentes.v_cargo = drd["v_cargo"].ToString();
                    lEListarAsistentes.Add(obEListarAsistentes);
                }
                drd.Close();
            }

            return (lEListarAsistentes);
        }
    }
}