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
    public class CAsistenciadni
    {
        public List<EAsistenciadni> Listar_Asistenciadni(SqlConnection con, String dni, String finicio, String ffin)
        {
            List<EAsistenciadni> lEAsistenciadni = null;
            SqlCommand cmd = new SqlCommand("ASP_ASISTENCIA_DIARIA_X_DNI", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;
            cmd.Parameters.AddWithValue("@finicio", SqlDbType.VarChar).Value = finicio;
            cmd.Parameters.AddWithValue("@ffin", SqlDbType.VarChar).Value = ffin;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEAsistenciadni = new List<EAsistenciadni>();

                EAsistenciadni obEAsistenciadni = null;
                while (drd.Read())
                {
                    obEAsistenciadni = new EAsistenciadni();
                    obEAsistenciadni.CODIGO = drd["CODIGO"].ToString();
                    obEAsistenciadni.DNI = drd["DNI"].ToString();
                    obEAsistenciadni.NOMBRE = drd["NOMBRE"].ToString();
                    obEAsistenciadni.TIPO_ASISTENCIA = drd["TIPO_ASISTENCIA"].ToString();
                    obEAsistenciadni.DIA = drd["DIA"].ToString();
                    obEAsistenciadni.FECHA = drd["FECHA"].ToString();
                    obEAsistenciadni.ENTRADA = drd["ENTRADA"].ToString();
                    obEAsistenciadni.INI_REF = drd["INI_REF"].ToString();
                    obEAsistenciadni.TER_REF = drd["TER_REF"].ToString();
                    obEAsistenciadni.SALIDA = drd["SALIDA"].ToString();
                    obEAsistenciadni.COMENTARIO = drd["COMENTARIO"].ToString();
                    obEAsistenciadni.ASISTENCIA = drd["ASISTENCIA"].ToString();
                    obEAsistenciadni.REFRIGERIO = drd["REFRIGERIO"].ToString();
                    obEAsistenciadni.ASISTENCIA_COLOR = drd["ASISTENCIA_COLOR"].ToString();
                    obEAsistenciadni.REFRIGERIO_COLOR = drd["REFRIGERIO_COLOR"].ToString();
                    obEAsistenciadni.STYLE = drd["STYLE"].ToString();
                    lEAsistenciadni.Add(obEAsistenciadni);
                }
                drd.Close();
            }

            return (lEAsistenciadni);
        }
    }
}